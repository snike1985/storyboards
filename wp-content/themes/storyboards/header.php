<?php
$home_id = 2;
$contact_id = 14;

$logo = get_field('logo', $home_id);
if($logo) {
    if(is_front_page()) {
	    $logo = '<div class="logo">'.$logo.'</div>';
    } else {
	    $logo = '<a href="'.get_home_url().'" class="logo">'.$logo.'</a>';
    }
}

$menu_name = 'menu';
$locations = get_nav_menu_locations();
$menu_list = '';
if( $locations && isset($locations[ $menu_name ]) ){
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	$menu_items = wp_get_nav_menu_items( $menu );
	$menu_list = '<div class="menu__links">';
	foreach ( (array) $menu_items as $key => $menu_item ){
		$perm = get_the_permalink($menu_item->object_id);
        $active = '';
        if (is_page( $menu_item->object_id )) {
          $active = ' active ';
        }
		$menu_list .= '<a href="'.$perm.'" class="menu__links-item'.$active.'"><span>'.$menu_item->title.'</span></a>';
	}
	$menu_list .= '</div>';
}

$social_links = get_field('social_links', $contact_id);
$social_links_list = '';
if(!empty($social_links)) {
	foreach ( $social_links as $row ) {
		if(is_array($row['show_in'])) {
          if(!in_array('0', $row['show_in']) || empty($row['image'])) {
            continue;
          }
		}else {
          if($row['show_in'] !== '0' || empty($row['image'])) {
            continue;
          }
        }
      $social_links_list .= '<a class="social__item" href="'.$row['url'].'" target="_blank">'.file_get_contents($row['image']['url']).'</a>';
	}
}
$title_button_header = get_field('title_button_header', $home_id);
if($title_button_header) {
    $title_button_header = '<a href="#" class="btn btn_transparent request-btn"><span>'.$title_button_header.'</span></a>';
}

$title_form_header = get_field('title_form_header', $home_id);
$title_form_header_string = '';
if(!empty($title_form_header)) {
	$title_form_header_string = '<strong class="request__title">';
    foreach ($title_form_header as $row) {
        $title_form_header_string .= '<span class="request__title-item"><span>'.$row['title'].'</span></span>';
    }
	$title_form_header_string .= '</strong>';
}
$class = '';
if(is_front_page()) {
    $class= ' site_main';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>Title</title>
    <?php wp_head(); ?>
    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            background-color: #f5f5f5;
        }
        .loader.hide {
            opacity: 0;
            visibility: hidden;
            -webkit-animation: hideLoader 1s 1 ease-in-out both;
            animation: hideLoader 1s 1 ease-in-out both;
        }
        .loader__wrap {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80px;
            transform: translate(-50%,-50%);
        }
        .loader__wrap div {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 100%;
            background-color: #0c24fb;
            -webkit-animation: bouncedelay 1.4s infinite ease-in-out both;
            animation: bouncedelay 1.4s infinite ease-in-out both;
        }
        .loader__wrap div.loader__one {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }
        .loader__wrap div.loader__two {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        @-webkit-keyframes bouncedelay {
            0%, 80%, 100% { -webkit-transform: scale(0) }
            40% { -webkit-transform: scale(1) }
        }

        @keyframes bouncedelay {
            0%, 80%, 100% {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            40% {
                transform: scale(1);
                -webkit-transform: scale(1)
            }
        }

        @-webkit-keyframes hideLoader {
            0% {
                visibility: visible;
                opacity: 1;
            }
            100% {
                visibility: hidden;
                opacity: 0;
            }
        }

        @keyframes hideLoader {
            0% {
                visibility: visible;
                opacity: 1;
            }
            100% {
                visibility: hidden;
                opacity: 0;
            }
        }

    </style>

    <script type="text/javascript">
        window.heap=window.heap||[],heap.load=function(e,t){window.heap.appid=e,window.heap.config=t=t||{};var r=t.forceSSL||"https:"===document.location.protocol,a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=(r?"https:":"http:")+"//cdn.heapanalytics.com/js/heap-"+e+".js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(a,n);for(var o=function(e){return function(){heap.push([e].concat(Array.prototype.slice.call(arguments,0)))}},p=["addEventProperties","addUserProperties","clearEventProperties","identify","removeEventProperty","setEventProperties","track","unsetEventProperty"],c=0;c<p.length;c++)heap[p[c]]=o(p[c])};
        heap.load("1040637789");
    </script>
    <!-- Hotjar Tracking Code for http://designstudio.ag -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:668744,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter46275432 = new Ya.Metrika({
                        id:46275432,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/46275432" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-108422609-1', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->

</head>
<body>
<!-- loader -->
<div class="loader">

    <!-- loader__wrap -->
    <div class="loader__wrap">
        <div class="loader__one"></div>
        <div class="loader__two"></div>
        <div class="loader__three"></div>
    </div>
    <!-- /loader__wrap -->

</div>
<!-- /loader -->
<div class="site <?= $class; ?>">
    <header class="site__header">
        <?= $logo; ?>
        <?php if(!is_page_template('page-landing.php')) { ?>
        <nav class="menu">
            <span class="menu__btn"><span></span></span>
            <div class="menu__wrap">
                <div class="menu__head">
	                <?= $logo; ?>
                </div>
                <?= $menu_list; ?>
                <div class="menu__footer">
                    <div class="social">
                        <?= $social_links_list; ?>
                    </div>
                </div>
            </div>
        </nav>
        <?php } ?>
        <div class="request">
            <div class="request__wrap">
                <span class="request__close"></span>
                <?= $title_form_header_string; ?>
                <div class="request__form">
	                <?= do_shortcode('[contact-form-7 id="23" title="Contact form 1"]'); ?>
                </div>
            </div>
        </div>
       <?= $title_button_header; ?>
    </header>