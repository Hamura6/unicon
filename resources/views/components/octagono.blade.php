@props(['img'=>null])
<div class="col-sm-12 col-md-4 col-lg-3">
    <div class="inventory">
        <div class="hexagon">
            <div class="shape">
                    {{$img}}
                <div class="btnhidden">
                    <div class="col-md-12">
                        {{$action}}
                    </div>
                </div>
                <div class="content">
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>
