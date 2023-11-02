<script>
    document.querySelector('.hamburger-icon').addEventListener('click', function() {
        var title = document.querySelector('.sidebar .title');
        title.style.display = (title.style.display === 'none' || title.style.display === '') ? 'block' : 'none';
    });
</script>
