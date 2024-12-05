@props(['slot' => null,'subtitle'=>null])
<div class="col-12">
    <div class="content" >
        <div class="content-body">
            <div class="content-header">
                <h2 class="title">
                    {{ $subtitle }}
                </h2>
            </div>
            {{ $slot }}
        </div>
    </div>

</div>
