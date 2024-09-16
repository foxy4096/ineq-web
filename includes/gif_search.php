<h2>Search for GIFs</h2>
<form id="gifSearchForm">
    <label for="query">Search GIFs:</label>
    <input type="text" id="query" name="query" required>
    <button type="submit">Search</button>
</form>
<br>
<div id="gifResults" style="display: flex; flex-wrap:wrap"></div>

<script>
document.getElementById('gifSearchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.getElementById('query').value;
    fetch(`fetch_gifs.php?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const gifResults = document.getElementById('gifResults');
            gifResults.innerHTML = '';
            if (data.error) {
                gifResults.innerHTML = '<p>' + data.error + '</p>';
                return;
            }
            data.results.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.media_formats.nanogif.url;
                img.alt = gif.title;
                img.style.width = '100px';
                img.style.cursor = 'pointer';
                img.addEventListener('click', () => {
                    document.getElementById('content').value += `![${gif.title}](${gif.media_formats.gif.url})`;
                });
                gifResults.appendChild(img);
            });
        });
});
</script>

