DELIMITER ;
DROP PROCEDURE IF EXISTS `lng_sync_lms_los_and_lonum`;
DELIMITER //
CREATE PROCEDURE `lng_sync_lms_los_and_lonum`()
BEGIN
  UPDATE    lng_lonum g
  JOIN      lms_los lmsc
  ON        (g.course_no_raw=SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1)
             AND
             IFNULL(NULLIF(TRIM(UPPER(g.`version`)),''),'1.0')=IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0')
            )
  SET       g.step=6,
            g.course_no=UPPER(TRIM(lmsc.course_no)),
            g.course_no_raw=SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1),
            g.`version`=IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0'),
            g.course_title=lmsc.course_title,
            g.course_duration=lmsc.duration,
            g.published_to_lms='Y',
            g.csod_loid=lmsc.lms_loid,
            g.updated_by=lmsc.lms_updated_by
  WHERE     g.step <> 6
  OR        g.course_no <> UPPER(TRIM(lmsc.course_no))
  OR        g.course_no_raw <> SUBSTRING_INDEX(UPPER(TRIM(lmsc.course_no)),'_V',1)
  OR        g.`version` <> IFNULL(NULLIF(TRIM(UPPER(lmsc.`version`)),''),'1.0')
  OR        g.course_title <> lmsc.course_title
  OR        g.course_duration <> lmsc.duration
  OR        g.published_to_lms <> 'Y'
  OR        g.csod_loid <> lmsc.lms_loid;

END//

DELIMITER ;

DROP EVENT IF EXISTS `lng_sync_lms_los_and_lonum_evnt`;
DELIMITER //
CREATE EVENT
  `lng_sync_lms_los_and_lonum_evnt`
  ON SCHEDULE
    EVERY 15 MINUTE
    STARTS STR_TO_DATE(DATE_FORMAT(NOW(), '%Y%m%d %H%i21'), '%Y%m%d %H%i%s' ) + INTERVAL 4 HOUR
    ON COMPLETION PRESERVE
  COMMENT 'Sync Between LMS Lookup table and LO Number Generator table'
  DO BEGIN
    /* New DB Event to run every 15 minutes to sync data between the LMS lookup table and main LO Number Generator Table */
    CALL lng_sync_lms_los_and_lonum();
    COMMIT;
  END//

DELIMITER ;
