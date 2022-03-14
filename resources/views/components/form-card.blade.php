@props(['header'])
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header text-md-center ">{{$header}}</h5>

                <div class="card-body">
                    {{--                  <choose-room />--}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
