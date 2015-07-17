<div>
<p>We heard that you lost your password. Sorry about that!</p>
<p>But don't worry! You can use the following link within the next day to reset your password:</p>
	{{ url('/reset?token='.$token) }}

</div>