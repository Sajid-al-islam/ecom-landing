<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Organic Ghor - Thank you</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center mt-5  ">
                    <img src="{{ asset('contents/frontend/landing/assets/img/thanks.png') }}" class="img-fluid" alt="">
                </div>
                <h2 class="my-4 text-center">
                    আপনার অর্ডারটি কনফার্ম হয়েছে! অতি শীগ্রই আমাদের একজন প্রতিনিধি আপনার সাথে যোগাযোগ করবে।
                </h2>
            </div>
        </div>
    </main>
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '418210320996583');
        fbq('track', 'PageView');
        fbq('track', 'Purchase',{
                value: 699,
                currency: 'BDT',
                content_ids: [1],
                content_type: 'product',
                "content_names": ["\u09e8\u09e7\u09e6 \u09ae\u09bf\u09b2\u09bf \u0985\u09df\u09c7\u09b2+\u09e7\u09eb\u09e6 \u0997\u09cd\u09b0\u09be\u09ae \u09ae\u09c7\u09b9\u09c7\u09a6\u09c0 \u09b9\u09c7\u09df\u09be\u09b0 \u09aa\u09cd\u09af\u09be\u0995 \u0995\u09ae\u09cd\u09ac\u09cb \u0964\u0964 \u09ab\u09cd\u09b0\u09c0 \u09a1\u09c7\u09b2\u09bf\u09ad\u09be\u09b0\u09bf"],
                "content_category": ["Hair oil"],
            });
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=418210320996583&ev=PageView&noscript=1" /></noscript>
</body>
</html>
