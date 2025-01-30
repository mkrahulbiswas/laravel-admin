<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive boder" style="border-top-left-radius: 0; border-top-right-radius: 0; margin-bottom: 0px;">

            <p class="text-muted font-14 m-b-30"></p>

            <form id="updateArrangeOrderForm" action="{{route('admin.update.arrangeOrder')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="sideNavBar" id="mainmenu">
                            @php $i=1; @endphp
                            @foreach ($sideNavBar as $itemOne)
                            <div class="items mainMenuItems list-group-item">
                                <div class="title mainMenuTitle">
                                    <div class="icons">
                                        <i class="md {{ $itemOne['icon'] }}"></i>
                                        <span>{{ $itemOne['name'] }}</span>
                                    </div>
                                </div>
                                <div class="items subMenuItems" id="">
                                    @foreach ($itemOne['subMenuData'] as $itemTwo)
                                    <div class="title subMenuTitle list-group-item">
                                        <div class="icons">
                                            {{-- <i class="md {{ $itemOne['icon'] }}"></i> --}}
                                            <span>{{ $itemTwo['name'] }}</span>
                                        </div>
                                        <input type="hidden" name="subMenuOrder[]" value="{{ $itemTwo['id'] }}">
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="mainMenuOrder" name="mainMenuOrder[]" value="{{ $itemOne['id'] }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <hr>

                    <div class="form-group text-right m-b-0 col-md-12">
                        <button type="submit" id="updateArrangeOrderBtn"  class="btn saveBtn waves-effect waves-light"><i class=""></i> <span>Update</span></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
.list-group-item{
    padding: 0 !important;
    margin: 0 !important;
}

.sideNavBar{}

.sideNavBar .items,
.sideNavBar .mainMenuItems .items{
    cursor: grab;
}

.sideNavBar .mainMenuItems .title,
.sideNavBar .mainMenuItems .subMenuItems .title{}

.sideNavBar .mainMenuItems{
    /* transition: 0.30s; */
    background: #e4ffe0;
    margin: 10px 15px 15px 15px !important;
    border-radius: 5px;
    box-shadow: 0px 10px 10px #b5b5b5;
    border: 1px solid gray;
    display: flex;
    flex-direction: row;
}
.sideNavBar .mainMenuItems:hover{
    background: #97ce8e;
}

.sideNavBar .mainMenuItems .mainMenuTitle{
    border-right: 2px solid black;
    padding: 10px 0;
    text-shadow: 0px 0px 20px #2c00ff;
    width: 200px;
    display: flex;
}

.sideNavBar .mainMenuItems .mainMenuTitle .icons{
    align-self: center;
    color: black;
    margin: auto;
}

.sideNavBar .mainMenuItems .subMenuItems{
    margin: 10px;
    flex-grow: 1;
}
.sideNavBar .mainMenuItems .subMenuItems:hover{

}

.sideNavBar .mainMenuItems .subMenuItems .subMenuTitle{
    background: #ffe0e0;
    border: none;
    padding: 5px 10px !important;
    margin: 5px !important;
    border-radius: 5px;
}

.sideNavBar .mainMenuItems .subMenuItems .subMenuTitle:hover{
    background: #dd9191;
}

@media only screen and (max-width: 600px) {
    .sideNavBar .mainMenuItems{
        flex-direction: column;
    }

    .sideNavBar .mainMenuItems .mainMenuTitle{
        border-right: none;
        border-bottom: 2px solid black;
        width: 100%;
    }
}
</style>