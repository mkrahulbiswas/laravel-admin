@extends('web.layouts.app')
@section('content')


<section>
	<div class="row">
		<header class="col-12 mainHeader mb-10 text-center">
			<h1 class="headingIV playfair fwEblod mb-7">Login into your account</h1>
		</header>
	</div>
	<div class="row">
		<div class="col-4"></div>
		<div class="col-md-4">
			<form class="contactForm" method="POST" action="{{ route('web.check.login') }}">
				@csrf
				<div class="form-group w-100 mb-6">
					<input type="text" class="form-control" id="email" name="email" placeholder="Your email  *">
				</div>

				<div class="form-group w-100 mb-6">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password  *">
				</div>

				<a href="{{ route('web.show.register') }}">register now</a>
				
				<div class="text-center">
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</form>
		</div>
	</div>
</section>


@endsection
