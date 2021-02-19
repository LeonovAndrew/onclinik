/*! jQuery Migrate v1.4.1 | (c) jQuery Foundation and other contributors | jquery.org/license */
"undefined"==typeof jQuery.migrateMute&&(jQuery.migrateMute=!0),function(a,b,c){function d(c){var d=b.console;f[c]||(f[c]=!0,a.migrateWarnings.push(c),d&&d.warn&&!a.migrateMute&&(d.warn("JQMIGRATE: "+c),a.migrateTrace&&d.trace&&d.trace()))}function e(b,c,e,f){if(Object.defineProperty)try{return void Object.defineProperty(b,c,{configurable:!0,enumerable:!0,get:function(){return d(f),e},set:function(a){d(f),e=a}})}catch(g){}a._definePropertyBroken=!0,b[c]=e}a.migrateVersion="1.4.1";var f={};a.migrateWarnings=[],b.console&&b.console.log&&b.console.log("JQMIGRATE: Migrate is installed"+(a.migrateMute?"":" with logging active")+", version "+a.migrateVersion),a.migrateTrace===c&&(a.migrateTrace=!0),a.migrateReset=function(){f={},a.migrateWarnings.length=0},"BackCompat"===document.compatMode&&d("jQuery is not compatible with Quirks Mode");var g=a("<input/>",{size:1}).attr("size")&&a.attrFn,h=a.attr,i=a.attrHooks.value&&a.attrHooks.value.get||function(){return null},j=a.attrHooks.value&&a.attrHooks.value.set||function(){return c},k=/^(?:input|button)$/i,l=/^[238]$/,m=/^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,n=/^(?:checked|selected)$/i;e(a,"attrFn",g||{},"jQuery.attrFn is deprecated"),a.attr=function(b,e,f,i){var j=e.toLowerCase(),o=b&&b.nodeType;return i&&(h.length<4&&d("jQuery.fn.attr( props, pass ) is deprecated"),b&&!l.test(o)&&(g?e in g:a.isFunction(a.fn[e])))?a(b)[e](f):("type"===e&&f!==c&&k.test(b.nodeName)&&b.parentNode&&d("Can't change the 'type' of an input or button in IE 6/7/8"),!a.attrHooks[j]&&m.test(j)&&(a.attrHooks[j]={get:function(b,d){var e,f=a.prop(b,d);return f===!0||"boolean"!=typeof f&&(e=b.getAttributeNode(d))&&e.nodeValue!==!1?d.toLowerCase():c},set:function(b,c,d){var e;return c===!1?a.removeAttr(b,d):(e=a.propFix[d]||d,e in b&&(b[e]=!0),b.setAttribute(d,d.toLowerCase())),d}},n.test(j)&&d("jQuery.fn.attr('"+j+"') might use property instead of attribute")),h.call(a,b,e,f))},a.attrHooks.value={get:function(a,b){var c=(a.nodeName||"").toLowerCase();return"button"===c?i.apply(this,arguments):("input"!==c&&"option"!==c&&d("jQuery.fn.attr('value') no longer gets properties"),b in a?a.value:null)},set:function(a,b){var c=(a.nodeName||"").toLowerCase();return"button"===c?j.apply(this,arguments):("input"!==c&&"option"!==c&&d("jQuery.fn.attr('value', val) no longer sets properties"),void(a.value=b))}};var o,p,q=a.fn.init,r=a.find,s=a.parseJSON,t=/^\s*</,u=/\[(\s*[-\w]+\s*)([~|^$*]?=)\s*([-\w#]*?#[-\w#]*)\s*\]/,v=/\[(\s*[-\w]+\s*)([~|^$*]?=)\s*([-\w#]*?#[-\w#]*)\s*\]/g,w=/^([^<]*)(<[\w\W]+>)([^>]*)$/;a.fn.init=function(b,e,f){var g,h;return b&&"string"==typeof b&&!a.isPlainObject(e)&&(g=w.exec(a.trim(b)))&&g[0]&&(t.test(b)||d("$(html) HTML strings must start with '<' character"),g[3]&&d("$(html) HTML text after last tag is ignored"),"#"===g[0].charAt(0)&&(d("HTML string cannot start with a '#' character"),a.error("JQMIGRATE: Invalid selector string (XSS)")),e&&e.context&&e.context.nodeType&&(e=e.context),a.parseHTML)?q.call(this,a.parseHTML(g[2],e&&e.ownerDocument||e||document,!0),e,f):(h=q.apply(this,arguments),b&&b.selector!==c?(h.selector=b.selector,h.context=b.context):(h.selector="string"==typeof b?b:"",b&&(h.context=b.nodeType?b:e||document)),h)},a.fn.init.prototype=a.fn,a.find=function(a){var b=Array.prototype.slice.call(arguments);if("string"==typeof a&&u.test(a))try{document.querySelector(a)}catch(c){a=a.replace(v,function(a,b,c,d){return"["+b+c+'"'+d+'"]'});try{document.querySelector(a),d("Attribute selector with '#' must be quoted: "+b[0]),b[0]=a}catch(e){d("Attribute selector with '#' was not fixed: "+b[0])}}return r.apply(this,b)};var x;for(x in r)Object.prototype.hasOwnProperty.call(r,x)&&(a.find[x]=r[x]);a.parseJSON=function(a){return a?s.apply(this,arguments):(d("jQuery.parseJSON requires a valid JSON string"),null)},a.uaMatch=function(a){a=a.toLowerCase();var b=/(chrome)[ \/]([\w.]+)/.exec(a)||/(webkit)[ \/]([\w.]+)/.exec(a)||/(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a)||/(msie) ([\w.]+)/.exec(a)||a.indexOf("compatible")<0&&/(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a)||[];return{browser:b[1]||"",version:b[2]||"0"}},a.browser||(o=a.uaMatch(navigator.userAgent),p={},o.browser&&(p[o.browser]=!0,p.version=o.version),p.chrome?p.webkit=!0:p.webkit&&(p.safari=!0),a.browser=p),e(a,"browser",a.browser,"jQuery.browser is deprecated"),a.boxModel=a.support.boxModel="CSS1Compat"===document.compatMode,e(a,"boxModel",a.boxModel,"jQuery.boxModel is deprecated"),e(a.support,"boxModel",a.support.boxModel,"jQuery.support.boxModel is deprecated"),a.sub=function(){function b(a,c){return new b.fn.init(a,c)}a.extend(!0,b,this),b.superclass=this,b.fn=b.prototype=this(),b.fn.constructor=b,b.sub=this.sub,b.fn.init=function(d,e){var f=a.fn.init.call(this,d,e,c);return f instanceof b?f:b(f)},b.fn.init.prototype=b.fn;var c=b(document);return d("jQuery.sub() is deprecated"),b},a.fn.size=function(){return d("jQuery.fn.size() is deprecated; use the .length property"),this.length};var y=!1;a.swap&&a.each(["height","width","reliableMarginRight"],function(b,c){var d=a.cssHooks[c]&&a.cssHooks[c].get;d&&(a.cssHooks[c].get=function(){var a;return y=!0,a=d.apply(this,arguments),y=!1,a})}),a.swap=function(a,b,c,e){var f,g,h={};y||d("jQuery.swap() is undocumented and deprecated");for(g in b)h[g]=a.style[g],a.style[g]=b[g];f=c.apply(a,e||[]);for(g in b)a.style[g]=h[g];return f},a.ajaxSetup({converters:{"text json":a.parseJSON}});var z=a.fn.data;a.fn.data=function(b){var e,f,g=this[0];return!g||"events"!==b||1!==arguments.length||(e=a.data(g,b),f=a._data(g,b),e!==c&&e!==f||f===c)?z.apply(this,arguments):(d("Use of jQuery.fn.data('events') is deprecated"),f)};var A=/\/(java|ecma)script/i;a.clean||(a.clean=function(b,c,e,f){c=c||document,c=!c.nodeType&&c[0]||c,c=c.ownerDocument||c,d("jQuery.clean() is deprecated");var g,h,i,j,k=[];if(a.merge(k,a.buildFragment(b,c).childNodes),e)for(i=function(a){return!a.type||A.test(a.type)?f?f.push(a.parentNode?a.parentNode.removeChild(a):a):e.appendChild(a):void 0},g=0;null!=(h=k[g]);g++)a.nodeName(h,"script")&&i(h)||(e.appendChild(h),"undefined"!=typeof h.getElementsByTagName&&(j=a.grep(a.merge([],h.getElementsByTagName("script")),i),k.splice.apply(k,[g+1,0].concat(j)),g+=j.length));return k});var B=a.event.add,C=a.event.remove,D=a.event.trigger,E=a.fn.toggle,F=a.fn.live,G=a.fn.die,H=a.fn.load,I="ajaxStart|ajaxStop|ajaxSend|ajaxComplete|ajaxError|ajaxSuccess",J=new RegExp("\\b(?:"+I+")\\b"),K=/(?:^|\s)hover(\.\S+|)\b/,L=function(b){return"string"!=typeof b||a.event.special.hover?b:(K.test(b)&&d("'hover' pseudo-event is deprecated, use 'mouseenter mouseleave'"),b&&b.replace(K,"mouseenter$1 mouseleave$1"))};a.event.props&&"attrChange"!==a.event.props[0]&&a.event.props.unshift("attrChange","attrName","relatedNode","srcElement"),a.event.dispatch&&e(a.event,"handle",a.event.dispatch,"jQuery.event.handle is undocumented and deprecated"),a.event.add=function(a,b,c,e,f){a!==document&&J.test(b)&&d("AJAX events should be attached to document: "+b),B.call(this,a,L(b||""),c,e,f)},a.event.remove=function(a,b,c,d,e){C.call(this,a,L(b)||"",c,d,e)},a.each(["load","unload","error"],function(b,c){a.fn[c]=function(){var a=Array.prototype.slice.call(arguments,0);return"load"===c&&"string"==typeof a[0]?H.apply(this,a):(d("jQuery.fn."+c+"() is deprecated"),a.splice(0,0,c),arguments.length?this.bind.apply(this,a):(this.triggerHandler.apply(this,a),this))}}),a.fn.toggle=function(b,c){if(!a.isFunction(b)||!a.isFunction(c))return E.apply(this,arguments);d("jQuery.fn.toggle(handler, handler...) is deprecated");var e=arguments,f=b.guid||a.guid++,g=0,h=function(c){var d=(a._data(this,"lastToggle"+b.guid)||0)%g;return a._data(this,"lastToggle"+b.guid,d+1),c.preventDefault(),e[d].apply(this,arguments)||!1};for(h.guid=f;g<e.length;)e[g++].guid=f;return this.click(h)},a.fn.live=function(b,c,e){return d("jQuery.fn.live() is deprecated"),F?F.apply(this,arguments):(a(this.context).on(b,this.selector,c,e),this)},a.fn.die=function(b,c){return d("jQuery.fn.die() is deprecated"),G?G.apply(this,arguments):(a(this.context).off(b,this.selector||"**",c),this)},a.event.trigger=function(a,b,c,e){return c||J.test(a)||d("Global events are undocumented and deprecated"),D.call(this,a,b,c||document,e)},a.each(I.split("|"),function(b,c){a.event.special[c]={setup:function(){var b=this;return b!==document&&(a.event.add(document,c+"."+a.guid,function(){a.event.trigger(c,Array.prototype.slice.call(arguments,1),b,!0)}),a._data(this,c,a.guid++)),!1},teardown:function(){return this!==document&&a.event.remove(document,c+"."+a._data(this,c)),!1}}}),a.event.special.ready={setup:function(){this===document&&d("'ready' event is deprecated")}};var M=a.fn.andSelf||a.fn.addBack,N=a.fn.find;if(a.fn.andSelf=function(){return d("jQuery.fn.andSelf() replaced by jQuery.fn.addBack()"),M.apply(this,arguments)},a.fn.find=function(a){var b=N.apply(this,arguments);return b.context=this.context,b.selector=this.selector?this.selector+" "+a:a,b},a.Callbacks){var O=a.Deferred,P=[["resolve","done",a.Callbacks("once memory"),a.Callbacks("once memory"),"resolved"],["reject","fail",a.Callbacks("once memory"),a.Callbacks("once memory"),"rejected"],["notify","progress",a.Callbacks("memory"),a.Callbacks("memory")]];a.Deferred=function(b){var c=O(),e=c.promise();return c.pipe=e.pipe=function(){var b=arguments;return d("deferred.pipe() is deprecated"),a.Deferred(function(d){a.each(P,function(f,g){var h=a.isFunction(b[f])&&b[f];c[g[1]](function(){var b=h&&h.apply(this,arguments);b&&a.isFunction(b.promise)?b.promise().done(d.resolve).fail(d.reject).progress(d.notify):d[g[0]+"With"](this===e?d.promise():this,h?[b]:arguments)})}),b=null}).promise()},c.isResolved=function(){return d("deferred.isResolved is deprecated"),"resolved"===c.state()},c.isRejected=function(){return d("deferred.isRejected is deprecated"),"rejected"===c.state()},b&&b.call(c,c),c}}}(jQuery,window);

function initFancy() {
    //Попап менеджер FancyBox
    // data-fancybox="gallery" создание галереи
    // data-caption="<b>Подпись</b><br>"  Подпись картинки
    // data-width="2048" реальная ширина изображения
    // data-height="1365" реальная высота изображения
    // data-type="ajax" загрузка контента через ajax без перезагрузки
    // data-type="iframe" загрузка iframe (содержимое с другого сайта)
    $(".fancybox").fancybox({
        hideOnContentClick: true,
        protect: false, //защита изображения от загрузки, щелкнув правой кнопкой мыши.
        loop: true, // Бесконечная навигация по галерее
        arrows: true, // Отображение навигационные стрелки
        infobar: true, // Отображение инфобара (счетчик и стрелки вверху)
        toolbar: true, // Отображение панели инструментов (кнопки вверху)
        buttons: [ // Отображение панели инструментов по отдельности (кнопки вверху)
            // 'slideShow',
            // 'fullScreen',
            // 'thumbs',
            // 'share',
            //'download',
            //'zoom',
            'close'
        ],
        touch: {
            vertical: false,  // Позволяет перетаскивать содержимое по вертикали
        },
        animationEffect: "zoom", // анимация открытия слайдов "zoom" "fade" "zoom-in-out"
        transitionEffect: 'slide', // анимация переключения слайдов "fade" "slide" "circular" "tube" "zoom-in-out" "rotate'
        animationDuration: 500, // Длительность в мс для анимации открытия / закрытия
        transitionDuration: 1366, // Длительность переключения слайдов
        slideClass: '', // Добавить свой класс слайдам

    });
}

$(document).ready(function () {

	
		
		$(document).on("click",".accordion_block h4",function () {
			$(this).toggleClass('active');
			$(this).next().toggleClass('active');
		})
		
		$( ".on_ajax_form" ).each(function( ) {
			var form_id = $(this).data('id');
			var bloc_id = $(this).attr('id');
			BX.ajax.insertToNode('/ajax/ajax_form.php?id=' + form_id, BX(bloc_id) );
		});
	
	
		$('body').on('click', '.load_more_service', function(e) {
		
			
			var direction_page = parseInt($('#direction_page').val());
			var services_page  = parseInt($('#services_page').val());
			var direction_all  = parseInt($('#direction_all').val());
			var services_all   = parseInt($('#services_all').val());
			var arDirectionsFilter  = $('#arDirectionsFilter').val();
			var arServicesFilter = $('#arServicesFilter').val();
		
			//if ( direction_page < direction_all ){
				
				
				
			//}	
			
			//if ( services_page < services_all ){
			
				
				
				$.ajax({
					type: 'POST',
					url: '/ajax/service/services.php?PAGEN_1='+services_page+'&ajax=Y',
					//url: '/ajax/service/services.php?ajax=Y',
					data: {arServicesFilter: arServicesFilter},
					success: function(data) {
						services_page = services_page + 1;
						
						$('#services').append( data );
						$('#services_page').val( services_page );
						
						if ( direction_page <= direction_all ){
							$.ajax({
								type: 'POST',
								url: '/ajax/service/directions.php?PAGEN_1='+direction_page+'&ajax=Y',
								//url: '/ajax/service/directions.php?ajax=Y',
								data: {arDirectionsFilter: arDirectionsFilter},
								success: function(data) {
									direction_page = direction_page + 1;
									$('#directions').append( data );
									$('#direction_page').val( direction_page );
								}
							});
						}
						
					}
				});
				
			//}	
			
			if ( direction_page >= direction_all && services_page >= services_all ){
				$('.load_more_service').hide();
			}
		});
	

    $('.clinic-btn-print').on('click', function(e) {
        e.preventDefault();
        window.print();
    });

    function swiperFunc1() {
        if ($(".swiper-container1").length > 0) {
            var swiper = new Swiper('.swiper-container1', {
                observer: true,
                observeParents: true,
                spaceBetween: 65,
                slidesPerView: 2,
                navigation: {
                    nextEl: '.swiper-button-next1',
                    prevEl: '.swiper-button-prev1',
                },
                breakpoints: {
                    600: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    }
                }
            });
            return false;
        }
    }

    function swiperFuncNew1() {
        if ($(".swiper-containerNew1").length > 0) {
            var swiper = new Swiper('.swiper-containerNew1', {
                observer: true,
                observeParents: true,
                spaceBetween: 65,
                slidesPerView: 2,
                navigation: {
                    nextEl: '.swiper-button-nextNew1',
                    prevEl: '.swiper-button-prevNew1',
                },
                breakpoints: {
                    600: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    }
                }
            });
            return false;
        }
    }

    function swiperFuncNew2() {
        if ($(".swiper-containerNew2").length > 0) {
            var swiper = new Swiper('.swiper-containerNew2', {
                observer: true,
                observeParents: true,
                spaceBetween: 65,
                slidesPerView: 2,
                navigation: {
                    nextEl: '.swiper-button-nextNew2',
                    prevEl: '.swiper-button-prevNew2',
                },
                breakpoints: {
                    600: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    }
                }
            });
            return false;
        }
    }


    function swiperFunc2() {
        if ($(".swiper-container2").length > 0) {
            var swiper = new Swiper('.swiper-container2', {
                observer: true,
                observeParents: true,
                spaceBetween: 65,
                slidesPerView: 2,
                navigation: {
                    nextEl: '.swiper-button-next2',
                    prevEl: '.swiper-button-prev2',
                },
                breakpoints: {
                    600: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    }
                }
            });
            return false;
        }
    }


    if ($(".swiper-container3").length > 0) {
        var swiper = new Swiper('.swiper-container3', {
            nested: true,
            pagination: {
                el: '.swiper-pagination3',
                clickable: true,
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
    }


    if ($(".swiper-container4").length > 0) {
        var swiper = new Swiper('.swiper-container4', {
            spaceBetween: 15,
            navigation: {
                nextEl: '.swiper-button-next4',
                prevEl: '.swiper-button-prev4',
            },
        });
    }


    if ($(".swiper-container5").length > 0) {
        var swiper = new Swiper('.swiper-container5', {
            navigation: {
                nextEl: '.swiper-button-next5',
                prevEl: '.swiper-button-prev5',
            },
        });
    }


    if ($(".swiper-container6").length > 0) {
        var swiper = new Swiper('.swiper-container6', {
            slidesPerView: 3,
            spaceBetween: 37,
            navigation: {
                nextEl: '.swiper-button-next6',
                prevEl: '.swiper-button-prev6',
            },
            breakpoints: {
                1000: {
                    slidesPerView: 2,
                    spaceBetween: 25
                },
                600: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container7").length > 0) {
        var swiper = new Swiper('.swiper-container7', {
            navigation: {
                nextEl: '.swiper-button-next7',
                prevEl: '.swiper-button-prev7',
            },
            breakpoints: {
                1359: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                700: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container8").length > 0) {
        var swiper = new Swiper('.swiper-container8', {
            slidesPerView: 3,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next8',
                prevEl: '.swiper-button-prev8',
            },
            breakpoints: {
                1359: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                700: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container9").length > 0) {
        var swiper = new Swiper('.swiper-container9', {
            autoHeight: true,
            navigation: {
                nextEl: '.swiper-button-next9',
                prevEl: '.swiper-button-prev9',
            },
        });
    }

    if ($(".swiper-container10").length > 0) {
        var swiper = new Swiper('.swiper-container10', {
            navigation: {
                nextEl: '.swiper-button-next10',
                prevEl: '.swiper-button-prev10',
            },
        });
    }

    if ($(".swiper-container11").length > 0) {
        var swiper = new Swiper('.swiper-container11', {
            navigation: {
                nextEl: '.swiper-button-next11',
                prevEl: '.swiper-button-prev11',
            },
        });
    }

    if ($(".swiper-container12").length > 0) {
        var swiper = new Swiper('.swiper-container12', {
            navigation: {
                nextEl: '.swiper-button-next12',
                prevEl: '.swiper-button-prev12',
            },
        });
    }


    if ($(".swiper-container13").length > 0) {
        var swiper = new Swiper('.swiper-container13', {
            slidesPerView: 3,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next13',
                prevEl: '.swiper-button-prev13',
            },
            breakpoints: {
                1850: {
                    slidesPerView: 2,
                    spaceBetween: 35
                },
                1000: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container14").length > 0) {
        var swiper = new Swiper('.swiper-container14', {
            slidesPerView: 5,
            spaceBetween: 34,
            navigation: {
                nextEl: '.swiper-button-next14',
                prevEl: '.swiper-button-prev14',
            },
            breakpoints: {
                1450: {
                    slidesPerView: 4,
                    spaceBetween: 15
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                850: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                550: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            },
            on: {
                init: function (swiper) {
                    console.log('Привет')
                  setHeight( $(".swiper-container14").find('.doctors-item') )
                },
                resize: function (swiper) {
                    $(".swiper-container14").find('.doctors-item').height('auto')

                    setHeight( $(".swiper-container14").find('.doctors-item') )
                }
            }
        });
    }

    if ($(".swiper-container15").length > 0) {
        var swiper = new Swiper('.swiper-container15', {
            slidesPerView: 2,
            spaceBetween: 50,
            navigation: {
                nextEl: '.swiper-button-next15',
                prevEl: '.swiper-button-prev15',
            },
            breakpoints: {
                1200: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container16").length > 0) {
        var swiper = new Swiper('.swiper-container16', {
            slidesPerView: 5,
            spaceBetween: 35,
            navigation: {
                nextEl: '.swiper-button-next16',
                prevEl: '.swiper-button-prev16',
            },
            breakpoints: {
                1450: {
                    slidesPerView: 4,
                    spaceBetween: 15
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                850: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
            }
        });
    }

    if ($(".swiper-container17").length > 0) {
        var swiper = new Swiper('.swiper-container17', {
            navigation: {
                nextEl: '.swiper-button-next17',
                prevEl: '.swiper-button-prev17',
            },
        });
    }

    if ($(".swiper-container18").length > 0) {
        var swiper = new Swiper('.swiper-container18', {
            slidesPerView: 4,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next18',
                prevEl: '.swiper-button-prev18',
            },
            breakpoints: {
                1800: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                1400: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                1000: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    function swiperFunc3() {
        function getLetter(slider, index) {
            return $(slider.slides[index]).data('letter');
        }
        if ($(".swiper-container19").length > 0) {
            var swiper = new Swiper('.swiper-container19', {
                init: false,
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: '.swiper-button-next19',
                    prevEl: '.swiper-button-prev19',
                },
                pagination: {
                    el: '.swiper-pagination19',
                    clickable: true,
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '"><span class="letter letter-' + index + '">' + getLetter(swiper, index) + '</span></span>';
                    },
                },
            });

            swiper.init();

            return false;
        }
    }

    if ($(".swiper-container20").length > 0) {
        var swiper = new Swiper('.swiper-container20', {
            slidesPerView: 4,
            spaceBetween: 25,
            navigation: {
                nextEl: '.swiper-button-next20',
                prevEl: '.swiper-button-prev20',
            },
            breakpoints: {
                1600: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                1200: {
                    slidesPerView: 2,
                    spaceBetween: 25
                },
                700: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container21").length > 0) {
        var swiper = new Swiper('.swiper-container21', {
            slidesPerView: 4,
            spaceBetween: 25,
            navigation: {
                nextEl: '.swiper-button-next21',
                prevEl: '.swiper-button-prev21',
            },
            breakpoints: {
                1870: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                1400: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                750: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container22").length > 0) {
        var swiper = new Swiper('.swiper-container22', {
            slidesPerView: 2,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next22',
                prevEl: '.swiper-button-prev22',
            },
            breakpoints: {
                1050: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    if ($(".swiper-container23").length > 0) {
        var swiper = new Swiper('.swiper-container23', {
            slidesPerView: 3,
            spaceBetween: 50,
            navigation: {
                nextEl: '.swiper-button-next23',
                prevEl: '.swiper-button-prev23',
            },
            breakpoints: {
                1100: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                650: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
            }
        });
    }

    function swiperFunc4() {
        if ($(".swiper-container24").length > 0) {
            var swiper = new Swiper('.swiper-container24', {
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: '.swiper-button-next24',
                    prevEl: '.swiper-button-prev24',
                },
            });
            return false;
        }
    }


    // Стилизация селектов
    (function ($) {
        $(function () {
            $('select').styler();
        });
    })(jQuery);

    (function ($) {
        $(function () {
            $('.file').styler();
        });
    })(jQuery);


    // табы
    $('.tabs_container .tab_listAll a').click(function(e) {
        e.preventDefault();

        let parent = $(this).closest('.tabs_container')

        parent.find('.tab_listAll li a').removeClass('active');

        $(this).addClass('active');

        let tab = $(this).attr('href');

        parent.find('.block_content').not(tab).css({'display':'none'});

        $(tab).fadeIn(400);
    });


    $(document).on('click', 'ul.tab_list a', function(e) {

        //window.location.hash =  $( this ).attr('href')
        e.preventDefault();
        $('ul.tab_list .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content').not(tab).css({'display': 'none'});
        $(tab).show();
		
		return false;
    });
    $(document).on('click', 'ul.tab_list1 a', function(e) {
        e.preventDefault();
        $('ul.tab_list1 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content1').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
		return false;
    });

    swiperFunc1();
    swiperFuncNew1();
    swiperFuncNew2();
    swiperFunc2();
    swiperFunc3();
    swiperFunc4();


// Конпка вверх
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });

    $('#toTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });


    if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
        document.body.classList.add('touch');
    } else {
        document.body.classList.add('no-touch');
    }


    $('.main-header-link1').on('click', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).children('.main-header-link1-list').slideDown();
        } else {
            $(this).children('.main-header-link1-list').slideUp();
        }

    });

    $('.map-btn').on('click', function () {
	
		if ( !$('.map-wrap').hasClass('loaded') ){
			$.getScript( "https://api-maps.yandex.ru/2.1/?apikey=870293a8-8ba5-4fd8-9948-dbc7ed29b9a7&lang=ru_RU" )
			  .done(function( script, textStatus ) {
					ymaps.ready(function() {
					let clinicsMap = new map('clinics-map'),
						mapParams = {
							center : [55.755, 37.615],
							zoom : 13,
						};

					clinicsMap.init(mapParams);
					clinicsMap.disableScrollZoom();
					clinicsMap.addFeatures(features);
					$('.map-wrap').addClass('loaded');
				});
			});
		}
	
		$('.map-wrap').toggleClass('active');
		if ($('.map-wrap').hasClass('active')) {
			$('.map-bg').fadeOut();
		} else {
			$('.map-bg').fadeIn();
		}
    });

    $('.map-bg').on('click', function () {
        $('.map-wrap').toggleClass('active');
        if ($('.map-wrap').hasClass('active')) {
            $('.map-bg').fadeOut();
        } else {
            $('.map-bg').fadeIn();
        }
    });


    $('.fixed-header-menu-toggle').on('click', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).parent().children('.fixed-header-list-wrap').slideDown();
        } else {
            $(this).parent().children('.fixed-header-list-wrap').slideUp();
        }

    });


    var $win = $(window),
        $fixed = $(".fixed"),
        limit = 300;

    function tgl(state) {
        $fixed.toggleClass("hidden-fixed", state);
    }

    $win.on("scroll", function () {
        var top = $win.scrollTop();

        if (top < limit) {
            tgl(true);
        } else {
            tgl(false);
        }
    });

    $('body').on('click', '.text-btn', function () {
        $(this).parent().toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.menu-btn').on('click', function () {
        $(this).parent().parent().toggleClass('active');
        $(this).parent().toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.contact1-btn1').on('click', function () {
        $(this).parent().parent().children('.contact1-list3').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.administration-btn').on('click', function () {
        $('.administration-list1').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.videos-btn').on('click', function () {
        $('.videos-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.search-btn').on('click', function () {
        $('.search-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.doctors-btn').on('click', function () {
        $('.doctors-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.certificates-btn').on('click', function () {
        $('.certificates-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.corporate-btn').on('click', function () {
        $('.corporate-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.programs-btn').on('click', function () {
        $('.programs-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.stock-btn2').on('click', function () {
        $('.stock-list2').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.faq-btn').on('click', function () {
        $('.faq-item-hidden').slideDown();
        $(this).toggleClass('active');
    });

    $('#directory-tab1 .directory-btn').on('click', function () {
		
		var count = $(this).parent().parent().find('.directory-list-wrap.hide_directory').length;
	
        // $(this).parent().parent().find('.directory-list').slideDown();
		$(this).parent().parent().find('.directory-list-wrap.hide_directory').filter(':first').removeClass('hide_directory');
        $(this).toggleClass('active');
		if ( count == 1 ){
			$(this).hide();
		}
    });

    $('#directory-tab2 .directory-btn').on('click', function () {
        $(this).parent().parent().children('.directory-list').slideDown();
        $(this).toggleClass('active');
    });

    $('.directory-slider .directory-btn').on('click', function () {
        $(this).closest('.swiper-slide').find('.directory-list').slideDown()
        $(this).toggleClass('active')
    })

    $(document).on('click', '.directory-specialization a', function () {
        $('#directory-tab2').addClass('hidden');
    });

    $('.action-programs-btn').on('click', function () {
        $('.action-programs-list li').slideDown();
        $('.action-programs-btn').toggleClass('active');
    });

    $('.health-btn').on('click', function () {
        $('.health-list').slideDown();
        $('.health-btn').toggleClass('active');
    });

    $(document).on('click', '.directory-specialization-tabs-btn', function () {
        $('.directory-specialization-tabs').fadeOut(0);
        $('.tab_list1 a').removeClass('active');
        $('#directory-tab2').removeClass('hidden');
    });

    $('.attendance-btn2').on('click', function () {
        $('.attendance-item-hidden').slideDown();
        $('.attendance-item-hidden').css("display", "flex");
        $('.attendance-item-hidden1').slideDown();
        $('.attendance-item-hidden1').css("display", "flex");
        $(this).toggleClass('active');
    });

    $('.main-header-menuToggle').on('click', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).parent().children('.main-header-nav').slideDown();
        } else {
            $(this).parent().children('.main-header-nav').slideUp();
        }

    });


    $(document).on('click', ".open_toggle", function (e) {
        e.preventDefault();
        if ($(this).next("div").is(":visible")) {
            $(this).next("div").slideUp(200);
            $(this).removeClass("active");
        } else {
            $(".block_toggle").slideUp(200);
            $(this).next("div").slideDown(200);
            $(this).parents().siblings().children(".open_toggle").removeClass("active");
            $(this).addClass("active");
        }
    });

    $('.banner .swiper-pagination-bullet').html('<i><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34"><g><g><path fill="none" d="M17 33c8.837 0 16-7.163 16-16S25.837 1 17 1 1 8.163 1 17s7.163 16 16 16z"/><path fill="none" stroke="none" stroke-miterlimit="50" d="M17 33c8.837 0 16-7.163 16-16S25.837 1 17 1 1 8.163 1 17s7.163 16 16 16z"/></g></g></svg></i>')


    /*if ($("#map").length > 0) {
        ymaps.ready(function () {
            var myMap = new ymaps.Map('map', {
                    center: [55.771996, 37.622262],
                    zoom: 15
                }, {
                    searchControlProvider: 'yandex#search'
                }),

                // Создаём макет содержимого.
                MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
                    '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
                ),

                myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                    hintContent: '',
                }, {
                    // Опции.
                    // Необходимо указать данный тип макета.
                    iconLayout: 'default#image',
                    // Своё изображение иконки метки.
                    iconImageHref: 'img/marker-map.png',
                    // Размеры метки.
                    iconImageSize: [38, 49],
                    // Смещение левого верхнего угла иконки относительно
                    // её "ножки" (точки привязки).
                    iconImageOffset: [-19, -49]
                });

            myMap.geoObjects
                .add(myPlacemark);

            myMap.behaviors.disable('scrollZoom');
        });
    }*/

    /*if ($("#map1").length > 0) {
        ymaps.ready(function () {
            var myMap = new ymaps.Map('map1', {
                    center: [55.771996, 37.622262],
                    zoom: 15
                }, {
                    searchControlProvider: 'yandex#search'
                }),

                // Создаём макет содержимого.
                MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
                    '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
                ),

                myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                    hintContent: '',
                }, {
                    // Опции.
                    // Необходимо указать данный тип макета.
                    iconLayout: 'default#image',
                    // Своё изображение иконки метки.
                    iconImageHref: 'img/marker-map.png',
                    // Размеры метки.
                    iconImageSize: [38, 49],
                    // Смещение левого верхнего угла иконки относительно
                    // её "ножки" (точки привязки).
                    iconImageOffset: [-19, -49]
                });

            myMap.geoObjects
                .add(myPlacemark);

            myMap.behaviors.disable('scrollZoom');
        });
    }*/

    initFancy();

    // Маска для формы телефона
    $("input[type='tel']").inputmask({"mask": "+7 (999) 999-9999"});
    // <input type="tel" placeholder="+7 (___) ___-___" name="tel">


    $(document).on('click', '.js-videoPoster', function (e) {
        //отменяем стандартное действие button
        e.preventDefault();
        var poster = $(this);
        // ищем родителя ближайшего по классу
        var wrapper = poster.closest('.js-videoWrapper');
        videoPlay(wrapper);
    });

    //вопроизводим видео, при этом скрывая постер
    function videoPlay(wrapper) {
        var iframe = wrapper.find('.js-videoIframe');
        // Берем ссылку видео из data
        var src = iframe.data('src');
        // скрываем постер
        wrapper.addClass('videoWrapperActive');
        // подставляем в src параметр из data
        iframe.attr('src', src);
    }


    if ($(".service1-nav").length > 0) {
        (function () {
            var a = document.querySelector('.service1-nav'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
            window.addEventListener('scroll', Ascroll, false);
            document.body.addEventListener('scroll', Ascroll, false);

            function Ascroll() {
                if (b == null) {
                    var Sa = getComputedStyle(a, ''), s = '';
                    for (var i = 0; i < Sa.length; i++) {
                        if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
                            s += Sa[i] + ': ' + Sa.getPropertyValue(Sa[i]) + '; '
                        }
                    }
                    b = document.createElement('div');
                    b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
                    a.insertBefore(b, a.firstChild);
                    var l = a.childNodes.length;
                    for (var i = 1; i < l; i++) {
                        b.appendChild(a.childNodes[1]);
                    }
                    a.style.height = b.getBoundingClientRect().height + 'px';
                    a.style.padding = '0';
                    a.style.border = '0';
                }
                var Ra = a.getBoundingClientRect(),
                    R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('.service1-wrap3').getBoundingClientRect().top + 0);  // селектор блока, при достижении верхнего края которого нужно открепить прилипающий элемент;  Math.round() только для IE; если ноль заменить на число, то блок будет прилипать до того, как нижний край элемента дойдёт до футера
                if ((Ra.top - P) <= 0) {
                    if ((Ra.top - P) <= R) {
                        b.className = 'stop';
                        b.style.top = -R + 'px';
                    } else {
                        b.className = 'sticky';
                        b.style.top = P + 'px';
                    }
                } else {
                    b.className = '';
                    b.style.top = '';
                }
                window.addEventListener('resize', function () {
                    a.children[0].style.width = getComputedStyle(a, '').width
                }, false);
            }
        })()
    }

    var mql = window.matchMedia('all and (max-width: 1359px)');
    if (mql.matches) {
        if ($(".section-wrap1").length > 0) {
            (function () {
                var a = document.querySelector('.section-wrap1'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
                window.addEventListener('scroll', Ascroll, false);
                document.body.addEventListener('scroll', Ascroll, false);

                function Ascroll() {
                    if (b == null) {
                        var Sa = getComputedStyle(a, ''), s = '';
                        for (var i = 0; i < Sa.length; i++) {
                            if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
                                s += Sa[i] + ': ' + Sa.getPropertyValue(Sa[i]) + '; '
                            }
                        }
                        b = document.createElement('div');
                        b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
                        a.insertBefore(b, a.firstChild);
                        var l = a.childNodes.length;
                        for (var i = 1; i < l; i++) {
                            b.appendChild(a.childNodes[1]);
                        }
                        a.style.height = b.getBoundingClientRect().height + 'px';
                        a.style.padding = '0';
                        a.style.border = '0';
                    }
                    var Ra = a.getBoundingClientRect(),
                        R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('.map').getBoundingClientRect().top + 120);  // селектор блока, при достижении верхнего края которого нужно открепить прилипающий элемент;  Math.round() только для IE; если ноль заменить на число, то блок будет прилипать до того, как нижний край элемента дойдёт до футера
                    if ((Ra.top - P) <= 0) {
                        if ((Ra.top - P) <= R) {
                            b.className = 'stop';
                            b.style.top = -R + 'px';
                        } else {
                            b.className = 'sticky';
                            b.style.top = P + 'px';
                        }
                    } else {
                        b.className = '';
                        b.style.top = '';
                    }
                    window.addEventListener('resize', function () {
                        a.children[0].style.width = getComputedStyle(a, '').width
                    }, false);
                }
            })()
        }
    }

    //tabs selection
    $(".service1-nav a").on('click', function (e) {
        if ($(this).data("is-tab")) {
            let href = $(this).attr("href"),
                destination = $("ul.tab_list.service1-tab_list").offset().top - 42; //50 отступ фикс меню

            e.preventDefault();

            //пролистывание
            $('html, body').animate(
                {
                    scrollTop: destination
                },
                600
            );

            //переключение
            $("ul.tab_list.service1-tab_list a[href='" + href + "']").click();
        }
    });


    $('body').on('click', '.service1-nav a', function () {
        let activeLink = $(this).attr('href')

        if ( $(activeLink).closest('.readmore-ent').hasClass('readmore') ) {
            let parent = $(activeLink).closest('.readmore-ent')

            parent.addClass('active')
            parent.find('.text-btn').addClass('active')

            $('html, body').stop().animate({
                scrollTop: $( activeLink ).offset().top - 42
            }, 600)
        }
    })


	$('body').on('click', '.directory-btn-wrap .directory-btn', function () {
        var k = false;
		var e = false;
		$('.hide_directory').each(function() {
			if ( !k ){
				$(this).removeClass('hide_directory');
				k = true;
			}
			else {
				e = true;
			}
		});
		if ( !e ){
			$('.directory-btn-wrap').hide();
		}
	})
	
	$('body').on('click', '.mobile-radio-wrap span', function () {
		$('.mobile-radio-wrap span').removeClass('active');
		$(this).addClass('active');
		$('.costsection-list1 .costsection-item').hide();
		var tab = $(this).data('tab');
		$('#'+tab).show();
		
		return false;	
	})
	
    var loationHash = window.location.hash

    if( loationHash && $('.service1-tabs').length ) {
        if( $(loationHash).closest('.service1-tabs').length ) {
            let activeTab = $('.tab_list a[href='+ loationHash +']')

            let parent = activeTab.closest('.service1-tabs')

            parent.find('.active').removeClass('active')

            $('.block_content').not(activeTab).css({'display': 'none'});

            activeTab.addClass('active')

            $( activeTab.attr('href') ).fadeIn(400)

            $('html, body').stop().animate({
                scrollTop: $( activeTab.attr('href') ).offset().top - 42
            }, 600)
        }
    }


    if( loationHash && $('.service1-nav').length ) {
        if( $(loationHash).closest('.readmore').length ) {
            setTimeout(function(){
                let activeLink = $('.service1-nav a[href='+ loationHash +']')

                let el = $(activeLink).attr('href')

                let parentEl = $(el).closest('.readmore')

                parentEl.addClass('active')
                parentEl.find('.text-btn').addClass('active')

                setTimeout(function(){
                    $('html, body').stop().animate({
                        scrollTop: $( activeLink.attr('href') ).offset().top - 42
                    }, 600)
                }, 300)
            }, 100)
        }
    }
});




$(function() {
    // Всплывающие окна
    $('.modal_link').click(function(e){
        e.preventDefault()

        $.fancybox.close()

        $.fancybox.open({
            src  : $(this).attr('href'),
            type : 'inline',
            opts : {
                touch : false,
                speed : 300,
                backFocus : false
            }
        })
    })
});

function showPopupMsg(msg) {
    let popupContent = '<section class="popup-window" id="success_modal">\n' +
        '<div class="modal_desc">' + msg + '</div>\n' +
        '</section>';

    $.fancybox.close()
    $.fancybox.open(popupContent);
}

$(document).ready(function() {
    readmore('.readmore');
});


function setHeight(className){
    let maxheight = 0
    let object = $(className)

    object.each(function() {
        let elHeight = $(this).innerHeight()

        if( elHeight > maxheight ) {
            maxheight = elHeight
        }
    })

    object.innerHeight( maxheight )
}


Share = {
	vkontakte: function(purl, ptitle, pimg, text) {
		url  = 'http://vkontakte.ru/share.php?';
		url += 'url='          + encodeURIComponent(purl);
		url += '&title='       + encodeURIComponent(ptitle);
		url += '&description=' + encodeURIComponent(text);
		url += '&image='       + encodeURIComponent(pimg);
		url += '&noparse=true';
		Share.popup(url);
	},
	odnoklassniki: function(purl, text) {
		url  = 'https://connect.ok.ru/offer?';
		//url += '&st.comments=' + encodeURIComponent(text);
		url += 'url='    + encodeURIComponent(purl);
		Share.popup(url);
	},
	facebook: function(purl, ptitle, pimg, text) {
		url  = 'http://www.facebook.com/sharer.php?s=100';
		url += '&p[title]='     + encodeURIComponent(ptitle);
		url += '&p[summary]='   + encodeURIComponent(text);
		url += '&p[url]='       + encodeURIComponent(purl);
		url += '&p[images][0]=' + encodeURIComponent(pimg);
		Share.popup(url);
	},
	twitter: function(purl, ptitle) {
		url  = 'http://twitter.com/share?';
		url += 'text='      + encodeURIComponent(ptitle);
		url += '&url='      + encodeURIComponent(purl);
		url += '&counturl=' + encodeURIComponent(purl);
		Share.popup(url);
	},
	mailru: function(purl, ptitle, pimg, text) {
		url  = 'http://connect.mail.ru/share?';
		url += 'url='          + encodeURIComponent(purl);
		url += '&title='       + encodeURIComponent(ptitle);
		url += '&description=' + encodeURIComponent(text);
		url += '&imageurl='    + encodeURIComponent(pimg);
		Share.popup(url)
	},

	popup: function(url) {
		window.open(url,'','toolbar=0,status=0,width=626,height=436');
	}
};




