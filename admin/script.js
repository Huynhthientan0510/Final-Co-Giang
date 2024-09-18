document.addEventListener('DOMContentLoaded', function() {
    // Handling form submission for creating an instructor
    const createInstructorBtn = document.getElementById('createInstructorBtn');
    const deleteInstructorBtn = document.getElementById('deleteInstructorBtn');

    if (createInstructorBtn) {
        createInstructorBtn.addEventListener('click', function (event) {
            event.preventDefault(); // prevent the default form submission

            // Get form data
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const role = document.getElementById('role').value;

            // Check if all fields are filled
            if (username && password && email && phone && role) {
                // Show a success message using SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Instructor Created',
                    text: `Instructor ${username} has been successfully created!`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // After confirmation, you can redirect or submit the form
                    document.getElementById('createInstructorForm').submit();
                });
            } else {
                // Show an error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Information',
                    text: 'Please fill in all the required fields!',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    if (deleteInstructorBtn) {
        deleteInstructorBtn.addEventListener('click', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Delete Instructor',
                text: 'Do you want to delete this instructor?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call your deletion logic here
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The instructor has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    }
});