$(".navbar a[href^='#'], .smooth").click(function() {
    var target = $($(this).attr('href')).offset().top;
    $('html, body').animate({
        scrollTop: target
    });
    return false;
});

// var author = '<div style="position: fixed;bottom: 0;left: 20px;background-color: #6777ef;box-shadow: 0 4px 8px rgba(0,0,0,.05);border-radius: 3px 3px 0 0;font-size: 12px;padding: 5px 10px;color: #fff;">By <a href="https://twitter.com/mhdnauvalazhar" class="text-light">@mhdnauvalazhar</a> &nbsp;&bull;&nbsp; <a href="https://www.buymeacoffee.com/mhdnauvalazhar" class="text-light">Buy me a Coffee</a></div>';
// $("body").append(author);

$("#my-button").fireModal({
  body: '<p>Your content goes here.</p>',
  created: function(modal) {
      console.log('Modal has been created');
  },
  buttons: [
    {
      text: 'Action',
      class: 'btn btn-primary btn-shadow',
      handler: function(modal) {
        // do something
        alert('Clicked');
      }
    }
  ]
});

$("#modal-1").fireModal({
  title: 'Login',
  body: $("#modal-login-part"),
  footerClass: 'bg-whitesmoke',
  autoFocus: false,
  onFormSubmit: function(modal, e, form) {
    // Form Data
    let form_data = $(e.target).serialize();
    console.log(form_data)

    // DO AJAX HERE
    let fake_ajax = setTimeout(function() {
      form.stopProgress();
      modal.find('.modal-body').prepend('<div class="alert alert-info">Please check your browser console</div>')

      clearInterval(fake_ajax);
    }, 1500);

    e.preventDefault();
  },
  shown: function(modal, form) {
    console.log(form)
  },
  buttons: [
    {
      text: 'Login',
      submit: true,
      class: 'btn btn-primary btn-shadow',
      handler: function(modal) {
      }
    }
  ]
});

$("#modal-2").fireModal({
  title: 'Ayuda',
  body: '<p> Descripción.</p>',
  created: function(modal) {
      console.log('Modal has been created Ayuda');
  },
  buttons: [
    {
      text: 'Cerrar',
      class: 'btn btn-primary btn-shadow',
      handler: function(modal) {
        // do something
      
      }
    }
  ]
});
