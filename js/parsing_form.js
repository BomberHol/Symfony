{
    document.querySelector('.user-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const formDataObj = {};

        formData.forEach((value, key) => {
            if (key !== 'avatar') {
                console.log(key, ' ', value);
                formDataObj[key] = value;
            }
        });
        
        try {
            let formDataJson = JSON.stringify(formDataObj);
            let response = await fetch('api/users/profile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=UTF-8'
                },
                body: formDataJson
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