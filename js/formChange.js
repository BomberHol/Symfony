{
    document.querySelector('.user-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        let query = window.location.search;
        const usrlParametr = new URLSearchParams(query);
        let userInfo = document.querySelector('.user-info');
        const spans = userInfo.querySelectorAll('span');
        const imgs = userInfo.querySelectorAll('img')
        const userInfoObj = {
            'user_id': usrlParametr.get('user_id'),
            'first_name':  spans[0]?.textContent,
            'last_name':   spans[1]?.textContent,   
            'middle_name': spans[2]?.textContent,
            'gender':     spans[3]?.textContent,
            'birth_date':  spans[4]?.textContent,
            'email':      spans[5]?.textContent,
            'phone':      spans[6]?.textContent,
            'avatar_path': imgs[0].getAttribute('src').replace('uploads/', '')
        };
        console.log(userInfoObj);


        const formData = new FormData(this);
        const formDataObj = {};
        formDataObj['user_id'] = userInfoObj['user_id'];
        formData.forEach((value, key) => {
             if (key !== 'avatar') {
                if (value === '') {
                    formDataObj[key] = userInfoObj[key]
                } else {
                    formDataObj[key] = value;
                }
            }
        });
        console.log(formDataObj);
        
        try {
            let formDataJson = JSON.stringify(formDataObj);
            let response = await fetch('/api/updateDataUser', {
                method: 'PATCH',
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