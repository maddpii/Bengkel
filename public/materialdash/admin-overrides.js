(function () {
  var submitButtons = document.querySelectorAll('[data-submit-target]');

  submitButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      var formId = button.getAttribute('data-submit-target');
      var form = document.getElementById(formId);

      if (form) {
        form.submit();
      }
    });
  });
})();
document.addEventListener("DOMContentLoaded", function () {
  const textFields = document.querySelectorAll('.mdc-text-field');
  textFields.forEach(el => {
    mdc.textField.MDCTextField.attachTo(el);
  });
});