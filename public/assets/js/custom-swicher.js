document.addEventListener('DOMContentLoaded', () => {
    const switch2 = document.getElementById('myonoffswitch2'); // Dark mode switch
    const switch1 = document.getElementById('myonoffswitch1'); // Light mode switch
    const switch3 = document.getElementById('myonoffswitch3'); // Light menu switch
    const switch5 = document.getElementById('myonoffswitch5'); // Dark menu switch
    const switch6 = document.getElementById('myonoffswitch6'); // Header-light switch
    const switch8 = document.getElementById('myonoffswitch8'); // Dark-header switch
    const htmlElement = document.documentElement; // Reference to the <html> element

    // Load dark mode state from localStorage
    if (localStorage.getItem('dark-mode') === 'true') {
        document.body.classList.add('dark-mode');
        document.body.classList.remove('light-mode');
        switch2.checked = true;
    } else {
        document.body.classList.add('light-mode');
        document.body.classList.remove('dark-mode');
        switch1.checked = true;
    }

    // Load menu state from localStorage
    if (localStorage.getItem('dark-menu') === 'true') {
        document.body.classList.add('dark-menu');
        switch5.checked = true;
    } else if (localStorage.getItem('light-menu') === 'true') {
        document.body.classList.add('light-menu');
        switch3.checked = true;
    }

    // Load dark header state from localStorage
    if (localStorage.getItem('dark-header') === 'true') {
        document.body.classList.add('dark-header');
        switch8.checked = true;
    }

    // Load header-light state from localStorage
    if (localStorage.getItem('header-light') === 'true') {
        document.body.classList.add('header-light');
        switch6.checked = true;
    }

    // Event listener for #myonoffswitch2 (dark mode)
    switch2.addEventListener('change', (event) => {
        if (event.target.checked) {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
            localStorage.setItem('dark-mode', 'true');

            // Uncheck light-mode switch
            switch1.checked = false;

            // Automatically check myonoffswitch5 (dark menu) and apply its behavior
            switch5.checked = true;
            document.body.classList.add('dark-menu');
            document.body.classList.remove('light-menu');
            localStorage.setItem('dark-menu', 'true');
            localStorage.removeItem('light-menu');

            // Automatically check myonoffswitch8 (dark header) and apply its behavior
            switch8.checked = true;
            document.body.classList.add('dark-header');
            document.body.classList.remove('header-light');
            localStorage.setItem('dark-header', 'true');
            localStorage.removeItem('header-light');
        }
    });

    // Event listener for #myonoffswitch1 (light mode)
    switch1.addEventListener('change', (event) => {
        if (event.target.checked) {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
            localStorage.setItem('dark-mode', 'false');

            // Uncheck dark-mode switch
            switch2.checked = false;

            // Automatically check myonoffswitch3 (light menu)
            switch3.checked = true;
            document.body.classList.add('light-menu');
            document.body.classList.remove('dark-menu');
            localStorage.setItem('light-menu', 'true');
            localStorage.removeItem('dark-menu');

            // Automatically check myonoffswitch6 (header-light)
            switch6.checked = true;
            document.body.classList.add('header-light');
            document.body.classList.remove('dark-header');
            localStorage.setItem('header-light', 'true');
            localStorage.removeItem('dark-header');
        }
    });

    // Event listener for #myonoffswitch3 (light and dark menu)
    switch3.addEventListener('change', (event) => {
        if (event.target.checked) {
            // Remove dark-menu class and add light-menu class
            document.body.classList.remove('dark-menu');
            document.body.classList.add('light-menu');
            
            // Save state in localStorage
            localStorage.setItem('light-menu', 'true');
            localStorage.removeItem('dark-menu');
        }
    });

    // Event listener for #myonoffswitch5 (toggle between light and dark menu)
    switch5.addEventListener('change', (event) => {
        if (event.target.checked) {
            document.body.classList.add('dark-menu');
            document.body.classList.remove('light-menu');

            // Save state in localStorage
            localStorage.setItem('dark-menu', 'true');
            localStorage.removeItem('light-menu');
        }
    });

    // Event listener for #myonoffswitch8 (dark header)
    switch8.addEventListener('change', (event) => {
        if (event.target.checked) {
            document.body.classList.add('dark-header');
            document.body.classList.remove('header-light');

            // Save state in localStorage
            localStorage.setItem('dark-header', 'true');
            localStorage.removeItem('header-light');
        }
    });

    // Event listener for #myonoffswitch6 (header-light and remove dark header)
    switch6.addEventListener('change', (event) => {
        if (event.target.checked) {
            document.body.classList.add('header-light');
            document.body.classList.remove('dark-header');

            // Save state in localStorage
            localStorage.setItem('header-light', 'true');
            localStorage.removeItem('dark-header');
        }
    });

   

    
});


// Check localStorage on page load and apply RTL or LTR
$(document).ready(function () {
    if (localStorage.getItem('vistartl') === 'true') {
        $('body').addClass('rtl');
        $("html[lang=en]").attr("dir", "rtl");
        $('body').removeClass('ltr');
        document.getElementById("style").setAttribute("href", "../assets/css/plugins/bootstrap/css/bootstrap.rtl.min.css");

        var carousel = $('.owl-carousel');
        $.each(carousel, function (index, element) {
            var carouselData = $(element).data('owl.carousel');
            carouselData.settings.rtl = true;
            carouselData.options.rtl = true;
            $(element).trigger('refresh.owl.carousel');
        });
    }

    if (localStorage.getItem('vistaltr') === 'true') {
        $('body').addClass('ltr');
        $("html[lang=en]").attr("dir", "ltr");
        $('body').removeClass('rtl');
        document.getElementById("style").setAttribute("href", "../assets/css/plugins/bootstrap/css/bootstrap.min.css");

        var carousel = $('.owl-carousel');
        $.each(carousel, function (index, element) {
            var carouselData = $(element).data('owl.carousel');
            carouselData.settings.rtl = false;
            carouselData.options.rtl = false;
            $(element).trigger('refresh.owl.carousel');
        });
    }
});

// Check localStorage on page load and apply RTL or LTR
$(document).ready(function () {
    // Check for RTL mode
    if (localStorage.getItem('vistartl') === 'true') {
        $('body').addClass('rtl');
        $("html[lang=en]").attr("dir", "rtl");
        $('body').removeClass('ltr');
        document.getElementById("style").setAttribute("href", "../assets/css/plugins/bootstrap/css/bootstrap.rtl.min.css");

        // Set the RTL switch to checked
        $('#myonoffswitch24').prop('checked', true);

        var carousel = $('.owl-carousel');
        $.each(carousel, function (index, element) {
            var carouselData = $(element).data('owl.carousel');
            carouselData.settings.rtl = true;
            carouselData.options.rtl = true;
            $(element).trigger('refresh.owl.carousel');
        });
    } else if (localStorage.getItem('vistaltr') === 'true') { // Check for LTR mode
        $('body').addClass('ltr');
        $("html[lang=en]").attr("dir", "ltr");
        $('body').removeClass('rtl');
        document.getElementById("style").setAttribute("href", "../assets/css/plugins/bootstrap/css/bootstrap.min.css");

        // Set the LTR switch to checked if applicable (if you have such a switch)
        $('#myonoffswitch23').prop('checked', true);

        var carousel = $('.owl-carousel');
        $.each(carousel, function (index, element) {
            var carouselData = $(element).data('owl.carousel');
            carouselData.settings.rtl = false;
            carouselData.options.rtl = false;
            $(element).trigger('refresh.owl.carousel');
        });
    }
});

// RTL STYLE START
$(document).on("click", '#myonoffswitch24', function () {
    if (this.checked) {
        $('body').addClass('rtl');
        $("html[lang=en]").attr("dir", "rtl");
        $('body').removeClass('ltr');
        document.getElementById("style").setAttribute("href", "../assets/css/plugins/bootstrap/css/bootstrap.rtl.min.css");

        var carousel = $('.owl-carousel');
        $.each(carousel, function (index, element) {
            var carouselData = $(element).data('owl.carousel');
            carouselData.settings.rtl = true;
            carouselData.options.rtl = true;
            $(element).trigger('refresh.owl.carousel');
        });
        localStorage.setItem('vistartl', true);
        localStorage.removeItem('vistaltr');
    }
});
// RTL STYLE END

// LTR STYLE START
$(document).on("click", '#myonoffswitch23', function () {
    if (this.checked) {
        $('body').addClass('ltr');
        $("html[lang=en]").attr("dir", "ltr");
        $('body').removeClass('rtl');
        document.getElementById("style").setAttribute("href", "../assets/css/plugins/bootstrap/css/bootstrap.min.css");

        var carousel = $('.owl-carousel');
        $.each(carousel, function (index, element) {
            var carouselData = $(element).data('owl.carousel');
            carouselData.settings.rtl = false;
            carouselData.options.rtl = false;
            $(element).trigger('refresh.owl.carousel');
        });
        localStorage.setItem('vistaltr', true);
        localStorage.removeItem('vistartl');
    }
});
// LTR STYLE END


 // Clear all data from localStorage
$('#ThemeReset').on('click', function() {
    localStorage.clear();
    // Reload the page
    location.reload();
});
