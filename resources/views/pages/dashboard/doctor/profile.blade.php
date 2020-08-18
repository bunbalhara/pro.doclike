@extends('layouts.theme')

@section('style')
    <style>
        .profile-container:hover .profile_edit {
            display: block;
        }
        .profile-container {
            display: none!important;
        }
        .profile_edit
        {
            padding-top: 7px;
            padding-right: 7px;
            position: absolute;
            right: 0;
            top: 0;
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="profile-container" style="background: url(../../theme/media/image/image1.jpg)">
	<div class="d-flex align-items-center">
		<figure class="avatar avatar-lg mr-3">
			<img src="{{auth()->user()->image()}}" class="rounded-circle" alt="...">
		</figure>
		<div>
			<h4 class="mb-0">{{auth()->user()->name}}</h4>
			<small>{{auth()->user()->userType()}}</small>
		</div>
	</div>
	<div class="profile-menu">
		<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
			<li class="flex-sm-fill text-sm-center nav-item">
				<a class="nav-link active" id="home-tab22" data-toggle="tab" href="#home"
				role="tab" aria-selected="true">Posts</a>
			</li>
			<li class="flex-sm-fill text-sm-center nav-item">
				<a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline"
				role="tab" aria-selected="true">Timeline</a>
			</li>
			<li class="flex-sm-fill text-sm-center nav-item">
				<a class="nav-link" id="connections-tab1" data-toggle="tab" href="#connections"
				role="tab"
				aria-selected="false">
					Connections
				</a>
			</li>
			<li class="flex-sm-fill text-sm-center nav-item">
				<a class="nav-link" id="earnings-tab" data-toggle="tab" href="#earnings"
				role="tab"
				aria-selected="false">Earnings</a>
			</li>
		</ul>
	</div>
    <div class="profile_edit"><a href="#"><i class="fa fa-pencil fa-lg"></i></a></div>
</div>

<div class="row">
	<div class="col-lg-7 col-md-12">
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="home" role="tabpanel">
				<div class="card">
					<div class="card-body">
						<div class="d-flex mb-3">
							<div class="d-flex">
								<figure class="avatar mr-3">
									<img src="../../theme/media/image/user/man_avatar1.jpg"
										class="rounded-circle" alt="...">
								</figure>
								<div class="d-inline-block">
									<div><strong>Martina Ash</strong> shared a link</div>
									<small class="text-muted">7 hours ago</small>
								</div>
							</div>
							<div class="dropdown ml-auto">
								<a href="#" class="btn btn-floating btn-sm" data-toggle="dropdown">
									<i class="ti-more-alt"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="#" class="dropdown-item">Share</a>
									<a href="#" class="dropdown-item">Edit</a>
									<a href="#" class="dropdown-item">Delete</a>
								</div>
							</div>
						</div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet dolor eos id
							ipsa
							nobis omnis, tenetur? Dolor officiis omnis quo?</p>
						<a href="#">
							<div class="row no-gutters border card flex-row border-radius-1">
								<div class="col-xl-3 col-lg-12">
									<img src="../../theme/media/image/photo1.jpg"
										class="img-fluid" alt="image/">
								</div>
								<div class="col-xl-9 col-lg-12 p-3">
									<h5>Algolia Integration</h5>
									<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet blanditiis cumque, cupiditate expedita fugiat iste iusto magni officia omnis ratione?</p>
									<small class="text-primary">https://themeforest.net/</small>
								</div>
							</div>
						</a>
						<div class="d-flex justify-content-between align-items-center mt-4">
							<div>
								<a href="#" title="Like" data-toggle="tooltip">
									<i class="fa fa-heart text-danger mr-1"></i> 42
								</a>
							</div>
							<div>
								<a href="#" title="Comments" data-toggle="tooltip">
									<i class="fa fa-comment-o mr-1"></i> 3
								</a>
								<a href="#" class="ml-3" title="Share" data-toggle="tooltip">
									<i class="fa fa-share mr-1"></i> 1
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="d-flex mb-3">
							<div class="d-flex">
								<figure class="avatar mr-3">
									<img src="../../theme/media/image/user/man_avatar3.jpg"
										class="rounded-circle" alt="...">
								</figure>
								<div class="d-inline-block">
									<div><strong>Martina Ash</strong> shared a link</div>
									<small class="text-muted">7 hours ago</small>
								</div>
							</div>
							<div class="dropdown ml-auto">
								<a href="#" class="btn btn-floating btn-sm" data-toggle="dropdown">
									<i class="ti-more-alt"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="#" class="dropdown-item">Share</a>
									<a href="#" class="dropdown-item">Edit</a>
									<a href="#" class="dropdown-item">Delete</a>
								</div>
							</div>
						</div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam doloremque
							eveniet illo minus nemo obcaecati, voluptatem? At corporis cum dolorem eos
							impedit in magni officiis quibusdam, ratione sequi totam voluptatum.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet dolor eos id
							ipsa
							nobis omnis, tenetur? Dolor officiis omnis quo?</p>
						<div class="d-flex justify-content-between align-items-center mt-4">
							<div>
								<a href="#" title="Like" data-toggle="tooltip">
									<i class="fa fa-heart-o mr-1"></i> 142
								</a>
							</div>
							<div>
								<a href="#" title="Comments" data-toggle="tooltip">
									<i class="fa fa-comment-o mr-1"></i> 13
								</a>
								<a href="#" class="ml-3" title="Share" data-toggle="tooltip">
									<i class="fa fa-share mr-1"></i> 4
								</a>
							</div>
						</div>
						<!-- People who wrote, liked, or shared a comment -->
						<div class="mt-4">
							<div class="card card-body border p-3">
								<div class="d-flex mb-3">
									<div class="d-flex align-items-center">
										<figure class="avatar avatar-sm mr-3">
											<img
												src="../../theme/media/image/user/man_avatar4.jpg"
												class="rounded-circle" alt="...">
										</figure>
										<div class="d-inline-block">
											<div><strong>Martina Ash</strong> shared a link</div>
											<small class="text-muted">7 hours ago</small>
										</div>
									</div>
									<div class="dropdown ml-auto">
										<a href="#" class="btn btn-floating btn-sm" data-toggle="dropdown">
											<i class="ti-more-alt"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="#" class="dropdown-item">Share</a>
											<a href="#" class="dropdown-item">Edit</a>
											<a href="#" class="dropdown-item">Delete</a>
										</div>
									</div>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus,
									ducimus?</p>
								<div class="d-flex justify-content-between align-items-center">
									<div>
										<a href="#" title="Like" data-toggle="tooltip">
											<i class="fa fa-heart-o mr-1"></i> 3
										</a>
										<a href="#" class="ml-3">
											Reply
										</a>
									</div>
								</div>
							</div>
							<div class="card card-body border p-3">
								<div class="d-flex mb-3">
									<div class="d-flex align-items-center">
										<figure class="avatar avatar-sm mr-3">
											<img
												src="../../theme/media/image/user/man_avatar1.jpg"
												class="rounded-circle" alt="...">
										</figure>
										<div class="d-inline-block">
											<div><strong>Martina Ash</strong> shared a link</div>
											<small class="text-muted">7 hours ago</small>
										</div>
									</div>
									<div class="dropdown ml-auto">
										<a href="#" class="btn btn-floating btn-sm" data-toggle="dropdown">
											<i class="ti-more-alt"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="#" class="dropdown-item">Share</a>
											<a href="#" class="dropdown-item">Edit</a>
											<a href="#" class="dropdown-item">Delete</a>
										</div>
									</div>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, ad,
									assumenda at atque corporis culpa earum id illum impedit laborum
									maxime
									minus nisi omnis quod sequi suscipit totam veritatis voluptatum.</p>
								<div class="d-flex justify-content-between align-items-center">
									<div>
										<a href="#" title="Like" data-toggle="tooltip">
											<i class="fa fa-heart-o mr-1"></i> 1
										</a>
										<a href="#" class="ml-3">
											Reply
										</a>
									</div>
								</div>
							</div>
							<form class="d-flex">
								<div>
									<figure class="avatar mr-3">
										<img
											src="../../theme/media/image/user/women_avatar1.jpg"
											class="rounded-circle" alt="...">
									</figure>
								</div>
								<div class="flex-grow-1">
									<div class="form-group">
												<textarea rows="2" class="form-control"
														placeholder="Post comment for @Martina"></textarea>
									</div>
									<button class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
						<!-- ./ People who wrote, liked, or shared a comment -->
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="d-flex mb-3">
							<div class="d-flex">
								<figure class="avatar mr-3">
									<img src="../../theme/media/image/user/women_avatar2.jpg"
										class="rounded-circle" alt="...">
								</figure>
								<div class="d-inline-block">
									<div>Anna Mull</div>
									<small class="text-muted">7 hours ago</small>
								</div>
							</div>
							<div class="dropdown ml-auto">
								<a href="#" class="btn btn-floating btn-sm" data-toggle="dropdown">
									<i class="ti-more-alt"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="#" class="dropdown-item">Share</a>
									<a href="#" class="dropdown-item">Edit</a>
									<a href="#" class="dropdown-item">Delete</a>
								</div>
							</div>
						</div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet dolor eos id
							ipsa
							nobis omnis, tenetur? Dolor officiis omnis quo?</p>
						<div class="row row-xs">
							<div class="col-6">
								<img src="../../theme/media/image/photo9.jpg"
									class="w-100 border-radius-1"
									alt="image/">
							</div>
							<div class="col-6">
								<img src="../../theme/media/image/photo10.jpg"
									class="w-100 border-radius-1"
									alt="image/">
							</div>
						</div>
						<div class="d-flex justify-content-between align-items-center mt-4">
							<div>
								<a href="#" title="Like" data-toggle="tooltip">
									<i class="fa fa-heart-o mr-1"></i> 311
								</a>
							</div>
							<div>
								<a href="#" title="Comments" data-toggle="tooltip">
									<i class="fa fa-comment-o mr-1"></i> 33
								</a>
								<a href="#" class="ml-3" title="Share" data-toggle="tooltip">
									<i class="fa fa-share mr-1"></i> 14
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade show" id="timeline" role="tabpanel">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Timeline</h6>
						<div class="timeline">
							<div class="timeline-item">
								<div>
									<a href="#">
										<figure class="avatar avatar-sm mr-3 bring-forward">
											<img
												src="../../theme/media/image/user/man_avatar2.jpg"
												class="rounded-circle" alt="image/">
										</figure>
									</a>
								</div>
								<div>
									<h6 class="d-flex justify-content-between mb-4">
										<span>
											<a href="#">Martina Ash</a> shared a link
										</span>
										<span class="text-muted font-weight-normal">Tue 8:17pm</span>
									</h6>
									<a href="#">
										<div class="mb-3">
											<div class="row no-gutters border card flex-row border-radius-1">
												<div class="col-xl-3 col-lg-12">
													<img
														src="../../theme/media/image/photo1.jpg"
														class="w-100"
														alt="image/">
												</div>
												<div class="col-xl-9 col-lg-12 p-3">
													<h5 class="line-height-16">Connection title</h5>
													Lorem ipsum dolor sit amet, consectetur adipisicing
													elit. Facilis, voluptatibus.
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="timeline-item">
								<div>
									<figure class="avatar avatar-sm mr-3 bring-forward">
													<span
														class="avatar-title bg-success-bright text-success rounded-circle">C</span>
									</figure>
								</div>
								<div>
									<h6 class="d-flex justify-content-between mb-4">
										<span>
											<a href="#">Jonny Richie</a> shared a post
										</span>
										<span class="text-muted font-weight-normal">Tue 8:17pm</span>
									</h6>
									<a href="#">
										<div class="mb-3 border p-3 border-radius-1">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab
											aliquid aperiam commodi culpa debitis deserunt enim itaque
											laborum minima neque nostrum pariatur perspiciatis, placeat
											quidem, ratione recusandae reiciendis sapiente, ut veritatis
											vitae. Beatae dolore hic odio! Esse officiis quidem
											voluptate.
										</div>
									</a>
								</div>
							</div>
							<div class="timeline-item">
								<div>
									<figure class="avatar avatar-sm mr-3 bring-forward">
													<span
														class="avatar-title bg-info-bright text-info rounded-circle">K</span>
									</figure>
								</div>
								<div>
									<h6 class="d-flex justify-content-between mb-4">
										<span>
											<a href="#">Jonny Richie</a> attached file
										</span>
										<span class="text-muted font-weight-normal">Tue 8:17pm</span>
									</h6>
									<a href="#">
										<div class="mb-3 border p-3 border-radius-1">
											<i class="fa fa-file-pdf-o mr-2"></i> filename12334.pdf
										</div>
									</a>
								</div>
							</div>
							<div class="timeline-item">
								<div>
									<figure class="avatar avatar-sm mr-3 bring-forward">
												<span class="avatar-title bg-warning-bright text-warning rounded-circle">
													<i class="ti-image/"></i>
												</span>
									</figure>
								</div>
								<div>
									<h6 class="d-flex justify-content-between mb-4">
										<span>
											<a href="#">Jonny Richie</a> shared files
										</span>
										<span class="text-muted font-weight-normal">Tue 8:17pm</span>
									</h6>
									<div class="row row-xs">
										<div class="col-xl-3 col-lg-4 col-md-6">
											<figure>
												<img
													src="../../theme/media/image/portfolio-five.jpg"
													class="w-100 border-radius-1" alt="image/">
											</figure>
										</div>
										<div class="col-xl-3 col-lg-4 col-md-6">
											<figure>
												<img
													src="../../theme/media/image/portfolio-one.jpg"
													class="w-100 border-radius-1" alt="image/">
											</figure>
										</div>
										<div class="col-xl-3 col-lg-4 col-md-6">
											<figure>
												<img
													src="../../theme/media/image/portfolio-three.jpg"
													class="w-100 border-radius-1" alt="image/">
											</figure>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div>
									<figure class="avatar avatar-sm mr-3 bring-forward">
										<span class="avatar-title bg-youtube rounded-circle">Y</span>
									</figure>
								</div>
								<div>
									<h6 class="d-flex justify-content-between">
									<span>
										<a href="#">Jonny Richie</a> shared video
									</span>
										<span class="text-muted font-weight-normal">Tue 8:17pm</span>
									</h6>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto,
										placeat.</p>
									<div class="row">
										<div class="col-md-6">
											<div
												class="embed-responsive embed-responsive-16by9 m-t-b-5">
												<iframe class="embed-responsive-item"
														src="https://www.youtube.com/embed/l-epKcOA7RQ"
														allowfullscreen></iframe>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="connections" role="tabpanel">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Connections</h6>
						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="card border">
									<div class="card-body p-3">
										<div class="d-flex align-items-center">
											<div>
												<figure class="avatar mr-3">
													<img
														src="../../theme/media/image/user/women_avatar2.jpg"
														class="rounded-circle" alt="...">
												</figure>
											</div>
											<div>
												<p class="mb-0">Rosemary Krout</p>
												<p class="small text-muted mb-0 line-height-15">
													Team Leader
												</p>
											</div>
											<a href="#" class="ml-auto" title="Message"
											data-toggle="tooltip">
												<i class="fa fa-comment-o"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="card border">
									<div class="card-body p-3">
										<div class="d-flex align-items-center">
											<div>
												<figure class="avatar mr-3">
													<img
														src="../../theme/media/image/user/women_avatar1.jpg"
														class="rounded-circle" alt="...">
												</figure>
											</div>
											<div>
												<p class="mb-0">Miller Edwins</p>
												<p class="small text-muted mb-0 line-height-15">
													Team Leader
												</p>
											</div>
											<a href="#" class="ml-auto" title="Message"
											data-toggle="tooltip">
												<i class="fa fa-comment-o"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="card border">
									<div class="card-body p-3">
										<div class="d-flex align-items-center">
											<div>
												<figure class="avatar mr-3">
													<img
														src="../../theme/media/image/user/women_avatar3.jpg"
														class="rounded-circle" alt="...">
												</figure>
											</div>
											<div>
												<p class="mb-0">Cahra Smiz</p>
												<p class="small text-muted mb-0 line-height-15">
													Agent
												</p>
											</div>
											<a href="#" class="ml-auto" title="Message"
											data-toggle="tooltip">
												<i class="fa fa-comment-o"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="card border">
									<div class="card-body p-3">
										<div class="d-flex align-items-center">
											<div>
												<figure class="avatar mr-3">
													<img
														src="../../theme/media/image/user/women_avatar4.jpg"
														class="rounded-circle" alt="...">
												</figure>
											</div>
											<div>
												<p class="mb-0">Burgess Attwool</p>
												<p class="small text-muted mb-0 line-height-15">
													Contact
												</p>
											</div>
											<a href="#" class="ml-auto" title="Message"
											data-toggle="tooltip">
												<i class="fa fa-comment-o"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="card border">
									<div class="card-body p-3">
										<div class="d-flex align-items-center">
											<div>
												<figure class="avatar mr-3">
													<img
														src="../../theme/media/image/user/man_avatar2.jpg"
														class="rounded-circle" alt="...">
												</figure>
											</div>
											<div>
												<p class="mb-0">Allx Life</p>
												<p class="small text-muted mb-0 line-height-15">
													Agent
												</p>
											</div>
											<a href="#" class="ml-auto" title="Message"
											data-toggle="tooltip">
												<i class="fa fa-comment-o"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="card border">
									<div class="card-body p-3">
										<div class="d-flex align-items-center">
											<div>
												<figure class="avatar mr-3">
													<img
														src="../../theme/media/image/user/man_avatar5.jpg"
														class="rounded-circle" alt="...">
												</figure>
											</div>
											<div>
												<p class="mb-0">Marti Sorbey</p>
												<p class="small text-muted mb-0 line-height-15">
													Contact
												</p>
											</div>
											<a href="#" class="ml-auto" title="Message"
											data-toggle="tooltip">
												<i class="fa fa-comment-o"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="earnings" role="tabpanel">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Earnings</h6>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead class="thead-light">
								<tr>
									<th>Date</th>
									<th>Item Sales Count</th>
									<th>Earnings</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>monday, 12</td>
									<td>
										3
									</td>
									<td>$400</td>
								</tr>
								<tr>
									<td>tuesday, 13</td>
									<td>
										2
									</td>
									<td>$400</td>
								</tr>
								<tr>
									<td>wednesday, 14</td>
									<td>
										3
									</td>
									<td>$420</td>
								</tr>
								<tr>
									<td>thursday, 15</td>
									<td>
										5
									</td>
									<td>$500</td>
								</tr>
								<tr>
									<td>friday, 15</td>
									<td>
										3
									</td>
									<td>$400</td>
								</tr>
								<tr>
									<td>saturday, 16</td>
									<td>
										3
									</td>
									<td>$400</td>
								</tr>
								<tr>
									<td>sunday, 17</td>
									<td>
										3
									</td>
									<td>$400</td>
								</tr>
								<tr>
									<td>monday, 18</td>
									<td>
										3
									</td>
									<td>$500</td>
								</tr>
								<tr>
									<td>tuesday, 19</td>
									<td>
										3
									</td>
									<td>$400</td>
								</tr>
								</tbody>
								<tfoot>
								<tr>
									<th></th>
									<th>28</th>
									<th>$3720</th>
								</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5 col-md-12">
		<div class="card">
			<div class="card-body">
				<h6 class="card-title d-flex justify-content-between align-items-center">
					Followers
					<a href="#" class="small">View All</a>
				</h6>
				<ul class="list-group list-group-flush">
					<li class="list-group-item d-flex align-items-center px-0">
						<figure class="avatar avatar-state-success mr-3">
							<img src="../../theme/media/image/user/women_avatar5.jpg" class="rounded-circle" alt="image">
						</figure>
						<div>
							<h6 class="mb-0">Valentine Maton</h6>
							<small class="text-muted">Engineer</small>
						</div>
					</li>
					<li class="list-group-item d-flex align-items-center px-0">
						<figure class="avatar avatar-state-success mr-3">
							<img src="../../theme/media/image/user/man_avatar1.jpg" class="rounded-circle" alt="image">
						</figure>
						<div>
							<h6 class="mb-0">Holmes Cherryman</h6>
							<small class="text-muted">Human resources</small>
						</div>
					</li>
					<li class="list-group-item d-flex align-items-center px-0">
						<figure class="avatar avatar-state-success mr-3">
							<img src="../../theme/media/image/user/women_avatar1.jpg" class="rounded-circle" alt="image">
						</figure>
						<div>
							<h6 class="mb-0">Malanie Hanvey</h6>
							<small class="text-muted">Real estate agent</small>
						</div>
					</li>
					<li class="list-group-item d-flex align-items-center px-0">
						<figure class="avatar avatar-state-success mr-3">
							<img src="../../theme/media/image/user/women_avatar2.jpg" class="rounded-circle" alt="image">
						</figure>
						<div>
							<h6 class="mb-0">Kenneth Hune</h6>
							<small class="text-muted">Engineer</small>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<h6 class="card-title d-flex justify-content-between align-items-center">
					Mutual Friends
					<a href="#" class="small">View All</a>
				</h6>
				<div class="d-flex align-items-center">
					<div class="avatar-group mr-2">
						<a href="#" class="avatar" data-toggle="tooltip" title="Valentine Maton">
							<img src="../../theme/media/image/user/women_avatar1.jpg" class="rounded-circle" alt="image">
						</a>
						<a href="#" class="avatar" data-toggle="tooltip" title="Holmes Cherryman">
							<img src="../../theme/media/image/user/man_avatar1.jpg" class="rounded-circle" alt="image">
						</a>
						<a href="#" class="avatar" data-toggle="tooltip" title="Malanie Hanvey">
							<img src="../../theme/media/image/user/man_avatar2.jpg" class="rounded-circle" alt="image">
						</a>
						<a href="#" class="avatar" data-toggle="tooltip" title="Kenneth Hune">
							<img src="../../theme/media/image/user/women_avatar2.jpg" class="rounded-circle" alt="image">
						</a>
						<a href="#" class="avatar" data-toggle="tooltip" title="Kenneth Hune">
							<img src="../../theme/media/image/user/women_avatar3.jpg" class="rounded-circle" alt="image">
						</a>
					</div>
					<span>+5 friends</span>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')

@endsection
