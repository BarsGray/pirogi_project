jQuery(document).ready(function ($) {
  
  // var entry_buff_seve = '';
  // var entry_title_buff_seve = '';
  var entryOrProduct = '';
  var breadCrambsForeProduct = '';

  if ($('.entry-content').length > 0) {
    // entry_title_buff_seve = $('h1.entry-title').text();
    // entry_buff_seve = $('.entry-content').html();
    entryOrProduct = 'entry';
  } else if ($('section.product').length > 0) {
    breadCrambsForeProduct = $('.woocommerce-breadcrumb').html();
    // entry_buff_seve = $('section.product .container').html();
    entryOrProduct = 'product';
  }


  function scrollSerchOnDasc() {
    if ($(window).width() > 992 && ($('header .search_form input[name="s"]').val().length > 0 || $('footer .search_form input[name="s"]').val().length > 0)) {
      let offsetVel = $(".entry-title").offset().top - 197;
      $("html, body").animate({ scrollTop: offsetVel }, 300);
    } else if ($(window).width() > 767 && $(window).width() < 993 && ($('header .search_form input[name="s"]').val().length > 0 || $('footer .search_form input[name="s"]').val().length > 0)) {
      let offsetVel = $(".entry-title").offset().top - 37;
      $("html, body").animate({ scrollTop: offsetVel }, 300);
    }
  }

  function scrollSerchOnMobile() {
    if ($(window).width() < 768 && ($('footer .search_form input[name="s"]').val().length > 0 || $('header .search_form input[name="s"]').val().length > 0)) {
      // if (entryOrProduct == 'product') {

        // let offsetVels = document.querySelector("section.product").offsetTop + 50;
        let offsetVels = document.querySelector("section.submenu").offsetTop + $('section.submenu').height() - 20;
        $("html, body").animate({ scrollTop: offsetVels }, 300);
      // } else {
      //   // let offsetVels = document.querySelector("secti.entry-title").offsetTop - 110;
      //   let offsetVels = document.querySelector("section.submenu").offsetTop + $('section.submenu').height() - 20;
      //   $("html, body").animate({ scrollTop: offsetVels }, 300);
      // }
    }
  }


  $('.search_form form').on('keydown', function (event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      scrollSerchOnDasc();
      $('header .search_form input[name="s"]').val('');
    }
  });

  $('.search_icon').on('click', function () {
    if ($(window).width() < 768) {
      scrollSerchOnMobile();
    } else {
      scrollSerchOnDasc();
      $('header .search_form input[name="s"]').val('');
    }
  });


  $('.search_form input[name="s"]').on('input', function () {

    if ($(window).width() < 768) {
      scrollSerchOnMobile();
    }
    // if (!document.URL.includes('/checkout')) {


    if ($(this).parent().parent().hasClass('search_form_footer')) {
      $('header .search_form input[name="s"]').val('');
    } else {
      $('footer .search_form input[name="s"]').val('');
    }

    var headerSearch = $('header .search_form input[name="s"]').val();
    var footerSearch = $('footer .search_form input[name="s"]').val();
    var search = '';

    if (headerSearch.length != 0) {
      search = headerSearch;
    } else if (footerSearch.length != 0) {
      search = footerSearch;
    }


    // if (search.length < 1) {
    //   if (entryOrProduct == 'entry') {
    //     $('h1.entry-title').text(entry_title_buff_seve);
    //     $('.entry-content').html(entry_buff_seve);
    //     location.reload();
    //   } else if (entryOrProduct == 'product') {
    //     $('section.product .container').html(entry_buff_seve);
    //     location.reload();
    //   }
    //   location.reload();
    //   setTimeout(() => {
    //     if ($('header .search_form input[name="s"]').val().length < 1) {
    //     }
    //   }, 1500);
    //   return false;
    // }
    var data = {
      s: search,
      action: 'search-ajax',
      nonce: search_form.nonce,
    };
    $.ajax({
      url: search_form.url,
      data: data,
      dataType: 'html',
      type: 'POST',
      beforeSend: function (xhr) {
      },
      success: function (data) {
        if (entryOrProduct == 'entry') {
          $('.entry-content').html('<div class="btn-back-holder search_btn_back_box"><a class="btn-back search_btn_back"></a></div>' + data);
          $('.btn-back-holder.search_btn_back_box').remove();
          let elmBtnBack = $('<div class="btn-back-holder search_btn_back_box"><a class="btn-back search_btn_back"></a></div>');
          let elemPrep = $('.entry-header');
          elemPrep.before(elmBtnBack);

          $('.search_btn_back').on('click', function () {
            location.reload();
          });
          $('h1.entry-title').text('Вы искали');
        } else if (entryOrProduct == 'product') {
          $('section.product .container').html('<nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">' + breadCrambsForeProduct + '</nav><article class="page type-page"><div class="btn-back-holder search_btn_back_box"><a class="btn-back search_btn_back"></a></div><h1 class="entry-title">Вы искали</h1>' + data + '</article>');
          $('.search_btn_back').on('click', function () {
            location.reload();
          });
        }
      }
    });
    // }
  });

});