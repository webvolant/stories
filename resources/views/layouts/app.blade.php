<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json" />

    <title>StoryMe: @yield('title')</title>
    <meta name="description" content="@yield('description')">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-T5NGP6M');</script>
    <!-- End Google Tag Manager -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://unpkg.com/primevue/resources/themes/saga-blue/theme.css " rel="stylesheet">
    <link href="https://unpkg.com/primevue/resources/primevue.min.css " rel="stylesheet">
    <link href="https://unpkg.com/primeicons/primeicons.css " rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://use.fontawesome.com/2b1e95b1c7.js"></script>
    <meta name="theme-color" content="#468996">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    <style>
        @font-face {
            font-family: nunitobold;
            src: url('/public/fonts/Nunito-Bold.ttf');
        }

        @font-face {
            font-family: nunitoregular;
            src: url('/public/fonts/Nunito-Regular.ttf');
        }

        body{
            font-family: 'nunitoregular', sans-serif;
        }

        h1,h2,h3{
            font-family: 'nunitobold', sans-serif;
        }

        .text-secondary{
            color:#DA3F97;
        }

        .text-primary{
            color:#DA3F97 !important;
        }

        .btn-primary{
            background:#DA3F97 !important;
            border-color: #DA3F97 !important;
        }

        .p-slider .p-slider-handle {
            height: 2.143rem !important;
            width: 2.143rem !important;
        }

        .p-slider.p-slider-horizontal .p-slider-handle {
            margin-top: -1rem !important;
            margin-left: -1rem !important;
        }

        .p-slider.p-slider-horizontal {
            height: 0.486rem !important;
        }
        .menu{
            background:#DA3F97;
            border:1px solid #e4e4e4;
            padding:10px 15px;
        }
        .menu a{
            color:white !important;
            font-size: 25px;
        }

        a{
            text-decoration: none;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
    <script>
	    // Check that service workers are supported
	    if ('serviceWorker' in navigator) {
		    // Use the window load event to keep the page load performant
		    window.addEventListener('load', () => {
			    navigator.serviceWorker.register('/service-worker.js');
		    });
	    }


		    /*var deferredPrompt;
		    window.addEventListener('beforeinstallprompt', function(event) {
			    event.preventDefault();
			    deferredPrompt = event;
			    return false;
		    });

		    function addToHomeScreen() {
			    if (deferredPrompt) {
				    deferredPrompt.prompt();
				    deferredPrompt.userChoice.then(function (choiceResult) {
					    console.log(choiceResult.outcome);
					    if (choiceResult.outcome === 'dismissed') {
						    console.log('User cancelled installation');
					    } else {
						    console.log('User added to home screen');
					    }
				    });
				    deferredPrompt = null;
			    }
		    }*/

    </script>
</head>
<body style="background: #fdfdfd;">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5NGP6M"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="app">



    <div class="container-fluid menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="">
                    <a href="{{ url('/') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Аудиосказки</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container-fluid">
    <main class="py-4">
        @yield('content')
    </main>
    </div>
    <div class="" >
        <!--<audio-player :files="localStorage.files" :item="localStorage.item"></audio-player>-->
    </div>

</div>


<script>
	//export const pwaTrackingListeners = () => {
		/*const fireAddToHomeScreenImpression = event => {
			//fireTracking("Add to homescreen shown");
			//will not work for chrome, untill fixed
			event.userChoice.then(choiceResult => {
				//fireTracking(`User clicked ${choiceResult}`);
			});
			//This is to prevent `beforeinstallprompt` event that triggers again on `Add` or `Cancel` click
			window.removeEventListener(
				"beforeinstallprompt",
				fireAddToHomeScreenImpression
			);
		};
		window.addEventListener("beforeinstallprompt", fireAddToHomeScreenImpression);

		//Track web app install by user
		window.addEventListener("appinstalled", event => {
			//fireTracking("PWA app installed by user!!! Hurray");
		});

		//Track from where your web app has been opened/browsed
		window.addEventListener("load", () => {
			let trackText;
			if (navigator && navigator.standalone) {
				trackText = "Launched: Installed (iOS)";
			} else if (matchMedia("(display-mode: standalone)").matches) {
				trackText = "Launched: Installed";
			} else {
				trackText = "Launched: Browser Tab";
			}
			//fireTracking(track);
		});*/
	//};
		var deferredPrompt;
		window.addEventListener('beforeinstallpromt', (e)=> {
					console.log("beforeinstallprompt fired");
			deferredPromt = e;
			//this.showAppInstallBanner = true;
		})

</script>



<script src="{{ asset('js/app.js') }}"></script>


<script>
	/*var deferredPrompt;
	window.addEventListener('beforeinstallprompt', function(e) {
		console.log("beforeinstallprompt fired");
		alert('hi');
		//e.preventDefault();
		deferredPrompt = e;
		//pwaToast.show();

	});*/

		/*window.addEventListener('beforeinstallprompt', function(e) {
					console.log("beforeinstallprompt fired");
			e.preventDefault();
			return false;
		});*/

	//alert('hi2222');
</script>

<script>
	/*function pwaToast(){

    }

	var deferredPrompt;
	window.addEventListener('beforeinstallprompt', function(e) {
		console.log("beforeinstallprompt fired");
		e.preventDefault();
		deferredPrompt = e;
		//pwaToast.show();
	});

	function installApp() {
		deferredPrompt.prompt();
		//pwaToast.hide();
		deferredPrompt.userChoice
		.then((choiceResult) => {
			if (choiceResult.outcome === 'accepted') {
				console.log('PWA setup accepted');
			} else {
				console.log('PWA setup rejected');
			}
			deferredPrompt = null;
		});
	}*/



</script>



</body>
</html>
