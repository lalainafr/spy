window.onload = () => {
    const FilterForm = document.querySelector('#filters')

    document.querySelectorAll('#filters input').forEach(input => {
        input.addEventListener('change', () => {

            const Form = new FormData(FilterForm);

            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value)
            })

            url = new URL(window.location.href);

            fetch(url.pathname + '?' + Params.toString() + '&ajax=1', {
                headers: {
                    "X-Requester-With": "XMLHttpRequest"
                }
            }).then(
                response => response.json()
            ).then(data => {
                const content = document.getElementById('content');
                content.innerHTML = data.content;
                history.pushState({}, null, url.pathname + '?' + Params.toString());
            }).catch(e => alert(e));
        });
    })
}