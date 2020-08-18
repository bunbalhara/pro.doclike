<div class="gallery-container row">
    @foreach ($doctors as $doctor)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 {{$doctor->category}} mb-4">
        <a href="javascript:void(0)" class="image-popup-gallery-item">
            <div class="card">
                <div class="like-tab bg-danger-bright text-danger" id="{{$doctor->id}}" data-id="{{$doctor->id}}">
                    <i class="fa fa-heart {{like($doctor->id) == 1 ? 'text-danger' : 'text-white'}}  mr-2"></i>
                    <span>{{$doctor->favourite->count()}}</span>
                </div>
                <div class="card-body">
                    <div class="my-3">
                        <img src="{{$doctor->image()}}" class="img-fluid rounded" alt="Vase">
                    </div>
                    <div class="text-center">
                        <a href="javascript:void(0)">
                            <h4>{{$doctor->name}}</h4>
                        </a>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <i class="fa fa-star text-warning"></i>
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-star text-warning"></i>
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-star text-warning"></i>
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-star-half-o text-warning"></i>
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-star-o"></i>
                            </li>
                            <li class="list-inline-item">(47)</li>
                        </ul>
                        <div class="badge bg-info-bright text-info">
                            @if ($doctor->categories)
                            {{$doctor->categories->name}}
                            @else
                            General 
                            @endif
                            </div>
                        <div class="mt-2">
                            <a class="btn btn-info text-white">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>