<img src="{{asset('front/img/bg.jpg')}}" class="w-100" style="height: 200px">

<div class="px-5">
    <div class="d-flex justify-content-between align-items-center">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
        <i class="fa fa-user" aria-hidden="true"></i>
        <img src="{{$user->image()}}" alt="" class="rounded-circle profile-img" width="120" style="margin-top: -60px">
        <i class="fa fa-heart-o" aria-hidden="true"></i>
        <i class="fa fa-map-marker" aria-hidden="true"></i>
    </div>
    <div class="text-center mt-2">
        <h5 style="font-weight: 400">{{$user->name}}</h5>
    </div>
    <div class="my-4">
        <div class="row">
            <div class="col-4 text-center">
                <h6>8</h6>
                <p class="text-muted small">POSTS</p>
            </div>
            <div class="col-4 text-center">
                <h6>8</h6>
                <p class="text-muted small">POSTS</p>
            </div>
            <div class="col-4 text-center">
                <h6>8</h6>
                <p class="text-muted small">POSTS</p>
            </div>
        </div>
    </div>
</div>