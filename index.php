<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comic Station</title>
    <link rel="stylesheet" href="./assets/style/style.css">
</head>

<body>
    <header>
        <h1 class="heading"> Comic Station </h1>
    </header>
    <main>
        <h2>XKCD Comics:</h2>

        <div class="flex-box">
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
        </div>

        <div class="subscribe">
            <h2>Subscription:</h2>
            <h4>To get updates about the XKCD Comics enter the Email and Subscribe</h4>
            <form>
                <div class="form">
                    <label>Email: </label>
                    <div>
                        <input type="email" id="email" placeholder="Your email *">
                        <div id="error">
                        </div>
                    </div>
                    <button type="button" onclick="VerifyAccount()">Subscribe
                    </button>
                </div>
            </form>
        </div>

    </main>
    <div class="prompt">
        <div class="prompt-container">
            <label>OTP</label>
            <div class="input-div">
                <input type="text" id="key">
                <div id="otp-error"></div>
            </div>
            <button type="button" onclick="Check()">Submit</button>
            <button type="button" onclick="Cancel()">Cancel</button>
        </div>
    </div>
    <div class="success-msg">
        <div>
            OTP is successfully verified.
            <button type="button" onclick="document.querySelector('.success-msg').style.display = 'none';">OK</button>
        </div>
    </div>

    <script>
    let boxs = document.querySelectorAll('.box')
    for (let i in boxs) {
        let r = Math.floor(Math.random() * 2000);
        fetch(`/api.php?q=random_comics`).then(async (d) => {
            d = await d.json();
            boxs[i].style.backgroundImage = `url(${d.img})`
        })
    }

    VerifyAccount = () => {
        let email = document.getElementById('email').value;
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!email) {
            document.getElementById('error').innerHTML = "** Fill all the details";
            return false;
        } else if (!filter.test(String(email).toLowerCase())) {
            document.getElementById('error').innerHTML = "** Please enter the correct email";
            return false;
        } else {
            document.getElementById('error').innerHTML = "";
            document.getElementById('email').value = "";
            fetch(`/api.php?q=VerifyAccount&e=${email}`).then(async (d) => {
                document.querySelector('.prompt').style.display = 'inline-block';
            })
        }
    }

    Check = () => {
        let key = document.getElementById('key').value;
        fetch(`/api.php?q=CheckKey&k=${key}`).then(async (d) => {
            d = await d.json();
            if (d.success === true) {
                document.querySelector('.prompt').style.display = 'none';
                document.getElementById('key').value = "";
                document.querySelector('.success-msg').style.display = 'block';
            } else {
                document.getElementById('otp-error').innerHTML = "OTP didn't matched";
            }
        })
        document.getElementById('otp-error').innerHTML = "";
    }

    Cancel = () => {
        document.querySelector('.prompt').style.display = 'none';
        document.getElementById('key').value = '';
        document.getElementById('otp-error').innerHTML = '';
    }
    </script>

</body>

</html>