<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
	* {
		transition: all 0.6s;
	}

	html {
		height: 100%;
	}

	body {
		font-family: 'Lato', sans-serif;
		color: #888;
		margin: 0;
	}

	a {
		text-decoration: none;
	}

	#main {
		display: table;
		width: 100%;
		height: 100vh;
		text-align: center;
	}

	.fof {
		display: table-cell;
		vertical-align: middle;
	}

	.fof h1 {
		font-size: 50px;
		display: inline-block;
		padding-right: 12px;
		animation: type .5s alternate infinite;
	}

	@keyframes type {
		from {
			box-shadow: inset -3px 0px 0px #888;
		}

		to {
			box-shadow: inset -3px 0px 0px transparent;
		}
	}
</style>
<div id='main'>
	<div class='fof'>
		<h1>Oh no!</h1>
		<div>Something went wrong. Please come <a href='<?= base_url('/') ?>'><b>Back</b></a> later. </div>
	</div>
</div>
