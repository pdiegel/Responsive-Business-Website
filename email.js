const modal = document.getElementById('modal');
const loading = document.getElementById('loading');
const modalHeading = document.getElementById('modal-heading');
const modalMessage = document.getElementById('modal-message');
const submitButton = document.getElementById('submit-button');

document.getElementById('contact-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission
    submitButton.disabled = true; // Disable the submit button to prevent multiple submissions
    submitButton.textContent = 'Submitting...';

    loading.classList.add('visible');

    const formData = new FormData(this);

    // Create the AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'submit.php', true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log('Success:', xhr.responseText);
        } else {
            console.log('The request failed!');
            modalHeading.textContent = 'Failed to send email.';
            modalMessage.textContent = 'Please try again later.';
        }
        loading.classList.remove('visible');
        modal.classList.add('visible');
        submitButton.textContent = 'Submit Form';
    };

    xhr.onerror = function () {
        console.log('Error during the AJAX request.');
        modalHeading.textContent = 'Error!';
        modalMessage.textContent = 'Network error, please try again later.';
        loading.classList.remove('visible');
        modal.classList.add('visible');
        submitButton.textContent = 'Submit Form';
    };

    // Actually send the form data
    xhr.send(formData);


});


document.getElementById('close-modal').addEventListener('click', function (_event) {
    modal.classList.remove('visible');
    modalHeading.textContent = 'Thank You for Your Submission!';
    modalMessage.textContent = 'We&apos;ll be in touch soon to schedule your discovery session. \
    In the meantime, feel free to explore our site and learn more about our services.';
    submitButton.disabled = false; // Re-enable the submit button
});
