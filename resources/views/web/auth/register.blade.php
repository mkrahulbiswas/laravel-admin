@extends('web.layouts.app')
@section('content')


<section>
	<div class="row">
		<header class="col-12 mainHeader mb-10 text-center">
			<h1 class="headingIV playfair fwEblod mb-7">Register with us</h1>
		</header>
	</div>
	<div class="row">
		<div class="col-4"></div>
		<div class="col-md-4">
			<form class="contactForm" method="POST" action="{{ route('web.save.register') }}" enctype="multipart/form-data">
				@csrf

				<div class="form-group w-100 mb-6">
					<input type="text" class="form-control" placeholder="Name" name="name">
				</div>

				<div class="form-group w-100 mb-6">
					<input type="text" class="form-control" placeholder="Email" name="email">
				</div>

				<div class="form-group w-100 mb-6">
					<input type="password" class="form-control" placeholder="Password" name="password">
				</div>

				<a href="{{ route('web.show.login') }}">login now</a>

				<div class="text-center">
					<button type="submit" class="btn btn-success">Sign Up</button>
				</div>
			</form>
		</div>
	</div>
</section>


@endsection
