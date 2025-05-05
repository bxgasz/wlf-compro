import Swal from "sweetalert2";

export class HelperService {
  static Toast = Swal.mixin({
    toast: true,
    position: 'top',
    customClass: {
        popup: 'colored-toast',
    },
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });

  static toastError(message: string) {
    this.Toast.fire({
      icon: 'error',
      title: 'Failed',
      text: message
    });
  }

  static toastSuccess(message: string) {
    this.Toast.fire({
      icon: 'success',
      title: 'Success!',
      text: message
    });
  }

  static errorMsg(message: string) {
    Swal.fire({
      icon: 'warning',
      title: 'Warning',
      text: message,
      showCancelButton: false,
      confirmButtonText: 'Oke',
    })
  }

  static confirmDelete(onDelete: CallableFunction, onSuccess?: CallableFunction) {
    Swal.fire({
      icon: 'warning',
      title: 'Warning',
      text: 'Are you sure want to delete this data?',
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: 'Yes, delete it',
      cancelButtonText: 'No',

    }).then( ({ isConfirmed }) => {
      if(isConfirmed) {
        Promise.resolve(onDelete())
        .then(() => {
          if (onSuccess) {
            onSuccess();
          }
        })
        .catch((error) => {
          // console.error('Error deleting data:', error);
          let message = 'Error deleting data';

          if (error.response && error.response.data) {
            if (error.response.data.message) {
              message = error.response.data.message;
            } else if (typeof error.response.data === 'string') {
              message = error.response.data;
            }
          }
          Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: message,
          });
        });
      }
    });
  }

  static confirmUpdate(onUpdate: CallableFunction, emit?: CallableFunction) {
    Swal.fire({
      icon: 'warning',
      title: 'Warning',
      text: 'Are you sure want to change this data?',
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: 'Yes, update data',
      cancelButtonText: 'No',

    }).then( ({ isConfirmed }) => {
      if(isConfirmed) {
          onUpdate();
          if (emit) {
            emit('confirmed')
          }
      }
    });
  }
}