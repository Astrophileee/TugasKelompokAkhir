import './bootstrap';

import Alpine from 'alpinejs';

import $ from 'jquery';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import 'datatables.net-dt';

import "@fortawesome/fontawesome-free/css/all.min.css";

import Swal from 'sweetalert2';
window.Swal = Swal;

document.addEventListener('DOMContentLoaded', () => {
    const successMessage = document.querySelector('meta[name="success-message"]')?.content;
    const errorMessage = document.querySelector('meta[name="error-message"]')?.content;

    if (successMessage) {
        Swal.fire({
            title: 'Success!',
            text: successMessage,
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }

    if (errorMessage) {
        Swal.fire({
            title: 'Failed!',
            text: errorMessage,
            icon: 'error',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }
});


$(document).ready(function() {
    $('.datatable').DataTable({
        "pageLength": 10,
        "lengthChange": false,
    });
});

window.Alpine = Alpine;

Alpine.start();
