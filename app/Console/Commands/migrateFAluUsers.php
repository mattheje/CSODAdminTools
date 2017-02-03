<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;


class migrateFAluUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migrateFAluUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will migrate fALU User into this system based on data copy-and-pasted into this script';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* Paste the data from this MyPLE query below, *** no headers, just CSL values ***:

        SELECT DISTINCT cad.csl
        FROM alu_ple_lms_course_gen cg
        LEFT JOIN um_user u ON (cg.owner_id=u.id)
        LEFT JOIN alu_ple_cadis cad ON (u.email=cad.email)
        GROUP BY cg.owner_id, u.email, cad.csl

         */

        $fAluUserData = <<<ENDUFALUUSERDATA
jansseto
vaillanb
jmendonc
laut009
lcorrale
acontino
rkissing
dshein
dberdani
cherokee
cdelmore
ls21fic
metadje1
jdiaz1
apash001
richaj
bstruble
bdeville
barthe14
pattyr
peigney1
nboiteux
songweic
acorrao
jschyman
ma03a04
sgilardi
dmccutch
patran
pcornill
regarcia
ijaber
pnaber
aprat
ENDUFALUUSERDATA;


        $users = explode("\n", $fAluUserData);
        $i=0;
        foreach ($users as $user) {
            $user = strtolower(trim($user));
            if ($user != '') {
                $userModel = new User();
                $userId = $userModel->importUserFromLdap($user, 'migration');
                if($userId > 0) {
                    $userModel->setUserPermission($userId, 'lonumadmin', 'migrate');
                    $userModel->setUserPermission($userId, 'lonumadminedit', 'migrate');
                    $userModel->setUserPermission($userId, 'scormautocompbuilder', 'migrate');
                    $userModel->setUserPermission($userId, 'scormautocompbuilder', 'migrate');
                    $i++;
                } //end if
            } //end if
        } //end foreach
        echo $i . " Total Users Imported/Migrated!";
        return true;
    } //end handle
} //end class
