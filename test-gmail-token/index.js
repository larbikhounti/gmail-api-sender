var request = require('request');
  let tokken = "ya29.a0Ad52N39DSn8OqkKoS6GQggRQUw3YKGoeC__o2RmNWw6LPMm7ZZl4CeY3mECzEJdZGwiNwsyKGCTQU1fY-AYSsy6cg1WtVP0vaOFYrHo8aMTCVajaIhIjBS33yy1vZ4xF2_us8wNe1dIFEeJBUSeBi5dHORsoWd8uxtmNaCgYKARoSARESFQHGX2Mi3Wdp7QhyENTaddKhPL6kbw0171"

  // Base64-encode the mail and make it URL-safe 
  // (replace all "+" with "-" and all "/" with "_")
  var encodedMail = new Buffer(
        "Content-Type: text/plain; charset=\"UTF-8\"\n" +
        "MIME-Version: 1.0\n" +
        "Content-Transfer-Encoding: 7bit\n" +
        "to: dmorris76@nc.rr.com\n" +
        "from: me <test@test.com>\n" +
        "subject: Subject Text\n\n" +

        "The actual message text goes here"
  ).toString("base64").replace(/\+/g, '-').replace(/\//g, '_');

  request({
      method: "POST",
      uri: "https://www.googleapis.com/gmail/v1/users/me/messages/send",
      headers: {
        "Authorization": `Bearer ${tokken}`,
        "Content-Type": "application/json",
        
      },
      body: JSON.stringify({
        "raw": encodedMail
      })
    },
    function(err, response, body) {
      if(err){
        console.log(err); // Failure
      } else {
        console.log(body); // Success!
      }
    });
