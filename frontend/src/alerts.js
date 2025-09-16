import Swal from 'sweetalert2';

export default {
  install(app) {
    app.config.globalProperties.$notification = {
      success(title, message) {
        Swal.fire({
          title: title,
          text: message,
          icon: 'success',
          timer: 1000,
          showConfirmButton: false,
        });
      },
      error(title, message) {
        Swal.fire({
          title: title,
          text: message,
          icon: 'error',
          timer: 1000,
          showConfirmButton: false,
        });
      },
    };
  },
};
