/**=====================
    Custom Dropzone  Start
==========================**/
var DropzoneExample = (function () {
  var initSingle = function () {
    Dropzone.options.singleFileUpload = {
      paramName: "file",
      maxFiles: 1,
      maxFilesize: 10,
      addRemoveLinks: true,
      acceptedFiles: ".xlsx,.xls,.csv",
      init: function () {
        this.on("sending", function (file, xhr, formData) {
          var form = this.element;
          var month = form.querySelector('#month');
          var year = form.querySelector('#year');
          var tokenInput = form.querySelector('input[name="_token"]');
          if (month) formData.append('month', month.value);
          if (year) formData.append('year', year.value);
          if (tokenInput) formData.append('_token', tokenInput.value);
        });
      }
    };
  };
  return {
    init: function () {
      initSingle();
    },
  };
})();
DropzoneExample.init();

/**=====================
    Custom Dropzone Ends
==========================**/
