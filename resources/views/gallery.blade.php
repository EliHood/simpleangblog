@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Gallery</h1>
			<div class="panel panel-default">
				<div id="eli-style-heading" class="panel-heading">Post an Image</div>
				<div class="panel-body">
					<form class="gallery_img" action="/uploadimage"  enctype="multipart/form-data" method="POST" novalidate>
						{{ csrf_field() }}
						<div class="form-group">
							<label for="exampleInputFile">Upload Image</label>
							<input name="gallery_name" type="file" class="form-control-file mt-4" id="exampleInputFile" aria-describedby="fileHelp">

							<input type="text" name="image_title" class="form-control eli-form" placeholder="Enter Image Name">
							
							<input type="hidden" name="_token" value="{{ csrf_token() }}">												
						</div>
						<button id="eli-style-button"  class="btn btn-primary" type="submit">Submit</button>
					</form>
				</div>
			</div>
			
		</div>
	</div>


<div class="row " >



<div class="my_container col-md-6 grid" ng-repeat="image in myimages" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 200 }'>
	<div class="content">
		<div class="content-overlay"></div>
		
		<img src="/uploads/gallery/<%image.file_name%>">
		
		<div class="content-details fadeIn-bottom grid-item">
			<i style="color:tomato; font-size:30px; line-height:50px;" ng-click="image_like(image); toggle = !toggle"
			ng-class="{[noheart] : !image.likedByMe, [heart]: image.likedByMe }">
			<h3 style="font-size:20px; margin:20px 0px; text-align:center;"  ng-bind="image.ImagelikesCount">  </h3>
			</i>
			<h3 class="content-title"><% image.image_title %></h3>
			<p class="content-text"> by <a  href="/profile/<% image.user.name | lowercase %>"><% image.user.name %></p>
		</div>
	</div>
</div>
	


</div>
</div>
@endsection