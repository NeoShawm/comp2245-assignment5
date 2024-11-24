document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lookup').addEventListener('click', function () {
        const country = document.getElementById('country').value;

        // Fetch country data
        fetch(`world.php?country=${country}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => {
                console.error('Fetch operation failed:', error);
            });
    });

    
    document.getElementById('lookup-cities').addEventListener('click', function () {
        const country = document.getElementById('country').value;

        fetch(`world.php?country=${country}&lookup=cities`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => {
                console.error('Fetch operation failed:', error);
            });
    });
});
