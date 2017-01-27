@if ($errors->any())
    <div class="alert alert-danger" style="color: #BE0006;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif