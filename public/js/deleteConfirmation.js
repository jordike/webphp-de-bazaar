document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();

            const form = button.closest(".delete-form");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33", // Red for confirm button
                cancelButtonColor: "#3085d6", // Blue for cancel button
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        });
    });
});
