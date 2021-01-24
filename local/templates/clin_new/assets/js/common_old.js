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
                delay: 3150,
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
                600: {
                    slidesPerView: 1,
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
    $(document).on('click', 'ul.tab_list a', function(e) {
        e.preventDefault();
        $('ul.tab_list .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $(document).on('click', 'ul.tab_list1 a', function(e) {
        e.preventDefault();
        $('ul.tab_list1 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content1').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list2 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list2 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content2').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list3 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list3 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content3').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list4 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list4 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content4').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list5 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list5 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content5').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list6 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list6 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content6').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list7 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list7 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content7').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });
    $('ul.tab_list8 a').click(function (e) {
        e.preventDefault();
        $('ul.tab_list8 .active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.block_content8').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });

    swiperFunc1();
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
        $('#directory-tab1 .directory-list').slideDown();
        $('#directory-tab1 .directory-btn').toggleClass('active');
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