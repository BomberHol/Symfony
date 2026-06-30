{
    let buttonDel = document.querySelector('.button-delete');
    buttonDel.addEventListener('click', async function (event) {
        let query = window.location.search;
        const usrlParametr = new URLSearchParams(query);
        let userId = usrlParametr.get('user_id');

        try {
            let response = await fetch(`api/deleteUser?user_id=${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json; charset=UTF-8'
                }
            });
            console.log(response);
            const data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            }

        } catch (error) {
            console.error('Ошибка запроса:', error);
        }

    })
}