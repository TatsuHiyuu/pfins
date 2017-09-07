$(document).ready(function() {
    /**
     * Attributs de chaque slider
     * */
    $('.slider').each(function(index) {
        var slider = $(this);
        var slides = slider.find('ul').children();
        var currentSlide = 0;
        slides[currentSlide].className = 'slide showing';

        $(document).on('click','a.previous', function () {
            if($(this).parent().data("slider") === index) {
                previousSlide();
            }
        });

        $(document).on('click','a.next', function () {
            if($(this).parent().data("slider") === index) {
                // console.log(currentSlide);
                nextSlide();
            }
        });

        /**
         * Agrandir / Réduire les contacts
         * */
        $(document).on('click','.plus',function () {
            var parent = $(this).parent();
            var slides = parent.find('ul').children();
            $(this).addClass('hiding');
            parent.find('.moins').removeClass('hiding');
            parent.find('a.next').addClass('hiding');
            parent.find('a.previous').addClass('hiding');

            slides.each(function() {
                $(this).removeClass('hiding').addClass('showing');
            });
        });

        $(document).on('click','.moins',function () {
            var parent = $(this).parent();
            var slides = parent.find('ul').children();

            $(this).addClass('hiding');
            parent.find('.plus').removeClass('hiding');
            if (slides.length > 1) {
                parent.find('a.next').removeClass('hiding');
                parent.find('a.previous').removeClass('hiding');
            }

            slides.each(function(index) {
                var slide = $(this);
                if(index !== 0) {
                    slide.removeClass('showing').addClass('hiding');
                }
                currentSlide = 0;
            });
        });

        /**
         * Avancer / Reculer d'un slide
         * */

        function previousSlide() {
            goToSlide(currentSlide-1);
        }

        function nextSlide() {
            goToSlide(currentSlide+1);
        }

        function goToSlide(n) {
            slides[currentSlide].className = 'slide hiding';
            currentSlide = (n+slides.length)%slides.length;
            slides[currentSlide].className = 'slide showing';
        }

    });

});