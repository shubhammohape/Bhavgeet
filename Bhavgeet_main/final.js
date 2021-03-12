const express = require('express')
const app = express()
const port = 3000;
const sphp = require('sphp')
const bcrypt = require('bcrypt')
const session = require('express-session')
const nodemailer =require('nodemailer')
var sess
const hbs = require('hbs')


app.set('view engine','hbs');
app.use(session({secret:'BhavgeetTool',saveUninitialized:false}))
app.use(sphp.express(__dirname));
app.use(express.static(__dirname))
app.use(express.urlencoded({
  extended: true
}))


const spotify =require('spotify-web-api-node');
const spotifyApi = new spotify({
  clientId: 'd97803efc75d48ea81360766acd7c5bb',
  clientSecret: 'd9db9f7988c3495e845aed7f21237fa6',
  redirectUri: 'http://localhost:3000/callback'
});
const mysql = require('mysql');
const { request } = require('http');
const { randomInt } = require('crypto');
var con = mysql.createConnection({
  host: "127.0.0.1",
  user: "root",
  password: "",
  database:"spotify-api"
});


//video
app.get('/video',(req,res)=>{
  sess= req.session
  
  if(sess.auth === 1)
  {
    res.redirect('/det_video.html')
  }
  else{
  res.redirect('./validation/user-validation.html')
  }
} )


//spotifyAPI
app.get('/authorize',(req,res)=>{

  sess= req.session
  
  if(sess.auth === 1)
  {
    app.locals.global_value = req.query.m;
 
    var scopes = ' streaming user-read-private user-read-email';
    res.redirect('https://accounts.spotify.com/authorize'+
      '?response_type=code' +
      '&client_id=d97803efc75d48ea81360766acd7c5bb'+
      (scopes ? '&scope=' + encodeURIComponent(scopes) : '') +
      '&redirect_uri=' + encodeURIComponent('http://localhost:3000/callback'));

    
  }
  else{
    res.redirect('./validation/user-validation.html')
  }

 
    
})


//callback


app.get('/callback',(reqr,resr)=>{
  const error = reqr.query.error;
  const code = reqr.query.code;
  var playlistno;
  if( app.locals.global_value === 'happy'){
    playlistno = '6pfOWoznf6TlqELmkVUuJ1'
    }
    else if( app.locals.global_value === 'angry')
    {
      playlistno = '4zE61Q9qXsAvokEn5Qdlu3'
    }
    else if( app.locals.global_value === 'surprised')
    {
      playlistno = '6gCRQkxRhmoXAPjYUFFFLz'
    }
    else if( app.locals.global_value === 'sad')
    {
      playlistno = '4YOfhHpjPB0tq29NPpDY3F'
    }
    else
    {
      playlistno = '71NI5fW6GZdHiaFu3HPKHO'
    }

  if(error){
    resr.redirect('./index2')
  }
  spotifyApi.authorizationCodeGrant(code).then((data)=>
  {
   const access_token = data.body['access_token'];
    const refresh_token = data.body['refresh_token'];
    const expires_in = data.body['expires_in'];

    spotifyApi.setAccessToken(access_token);
    spotifyApi.setRefreshToken(refresh_token);
 

  
   
  
   spotifyApi.getPlaylist(playlistno).then((data)=>{
        for(i=0; i < data.body.tracks.items.length ;i++)
        {
          const plname = data.body.name;
        const plurl =data.body.external_urls.spotify;
        const artistname =data.body.tracks.items[i].track.artists[0].name;
        if(data.body.tracks.items[i].track.artists[1]){
         var artistname2= data.body.tracks.items[i].track.artists[1].name;
        }else{
          var artistname2= "";
        }

      
        if(data.body.tracks.items[i].track.name.indexOf('\'') > -1)
        {
          var track = data.body.tracks.items[i].track.name
          var t =track.replace("'", " ")
          var trackname = t.toString().trim()
        }
        else{
         var trackname = data.body.tracks.items[i].track.name;
        }
        const duration = data.body.tracks.items[i].track.duration_ms;
        const src = data.body.tracks.items[i].track.external_urls.spotify;
        const img = data.body.tracks.items[i].track.album.images[0].url;
        const reldate = data.body.tracks.items[i].track.album.release_date;
        
        const sql = `insert into musicinfo(playlistname,Artistname,Trackname,duration,src,img,reldate,playlisturl,Artist2) values('${plname}','${artistname}','${trackname}',${duration},'${src}','${img}','${reldate}','${plurl}','${artistname2}')`
      
        con.query(sql,(err,resp)=>{
          if (err) {
          resr.redirect('./index2')
           }
          
        })

      }
      
      resr.redirect('/new')
    }).catch((error)=>{
   
      resr.redirect('./index2')
    })
  }).catch((error1)=>{
    
    resr.redirect('./index2')
  });


})


//Index Page
app.get('/',(req,res)=>{
  
});


//Webcam
app.get('/webcam',(req,res)=>{


  sess= req.session
  if(sess.auth === 1)
  {
    res.redirect('/webcam_ext.html')
  }
  else{
    res.redirect('./validation/user-validation.html')
  }
 
});

//AFter Login
app.get('/index2',(req,res)=>{


  sess= req.session
  if(sess.auth === 1)
  {
    res.redirect('/index2.html')
  }
  else{
    res.redirect('./validation/user-validation.html')
  }
 
});

//Login
app.post('/login',(req,res)=>{
sess = req.session;

const username =req.body.signname
const  password = req.body.signpassword
const sql12 = `select password from users where email='${username}'  `
con.query(sql12,(error,resl)=>{
  if(error)
  {
    sess.error = "Error ! Try later"
    res.render('user-validation',{err:sess.error})
    }
   
   bpass = resl[0].password
  bcrypt.compare(password,bpass,(err,result)=>{
    if(result==true)
    {
    sess.uname = username
    sess.auth = 1 
    sess.error =""
    res.redirect('./index2')
    }
    else
    {    
      sess.auth= 0
      sess.error = "Incorrect email or password"
      res.render('user-validation',{err:sess.error})
      }

  })
  
})


});

//Signup
app.post('/signup',(req,respo)=>{
const username = req.body.signupusername
const password = req.body.signuppassword
const repeatPassword = req.body.signuprppassword
const emailAddrss = req.body.signupemail
const vericode = randomInt(randomInt(1,40),randomInt(55,89)) + '' +  randomInt(randomInt(100,240),randomInt(555,989)) 
sess = req.session
sess.uname = emailAddrss

if(password === repeatPassword)
{
bcrypt.hash(password,8).then((data)=>{
  const bpass = data
  var transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: 'epic1470@gmail.com',
      pass: 'abcdefgh@12345'
    }
  });
  var mailOptions = {
    from: 'epic1470@gmail.com',
    to: emailAddrss,
    subject: 'Verification code',
    text: 'Your Verification code for account is '+ vericode +'.'
  };
  const sql = `insert into users(username,password,email,v_key,verified) values('${username}' , '${bpass}' ,'${emailAddrss}' ,${vericode},0)`
  con.query(sql,(err,res)=>{
    if (err) {
      sess.error= " Error ! Try Later" 
      respo.render("user-validation",{err:sess.error})
     }
     transporter.sendMail(mailOptions).then((data)=>{
      respo.redirect("./validation/verify.html")
  }).catch((err)=>{
      sess.error= "Error ! Try later "
      respo.render("user-validation",{err:sess.error})
    });
  })
 
  
}).catch((err)=>{
  sess.error= " Error! Try later"  
  respo.render("user-validation",{err:sess.error})
});
}
else{
sess.error= " Password Do not Match "  
respo.render("user-validation",{err:sess.error})
}

});



//verifyEmail
app.get('/verify',(req,res)=>{

  sess= req.session
  

  if(sess.auth === 1)
  {
    const sql18 = `select verified from users where email ='${sess.uname}'`

    con.query(sql18,(err,result)=>{
      if(err)
      {
      
        res.redirect('./index2')
      }
      if(parseInt(result[0].verified) === 1){
        res.redirect('./validation/alrverify.html') 
      }
      else{
        res.redirect('./validation/verify.html') 
      }
     
    })
    
  }
  else{
    res.redirect('./validation/user-validation.html')
  }
 
})

app.post('/verify',(reqr,resu)=>{
  
  sess = reqr.session 
  const vericoder = reqr.body.verifycode
  const sql1 = `select v_key from users where email='${sess.uname}' `
 con.query(sql1,(error,resl)=>{
  if (error) {
    sess.error= " Error! Try Later" 
    resu.render("verify-pass",{err:sess.error})
   }
 
   if(vericoder === (resl[0].v_key) )
   {
    const sql2 = `update users set verified=1 where email = '${sess.uname}'`

    con.query(sql2 , (e,r)=>{
      if(e)
      {
        sess.error= " Error ! Try Later " 
        resu.render("verify-pass",{err:sess.error})
      }
      sess.error= " Successfully verified" 
      resu.render("verify-pass",{err:sess.error})
    })


   }
   else{
    sess.error= "verification code wrong  " 
    resu.render("verify-pass",{err:sess.error})
   }
 })
 
 
})
//saveplaylist
app.get('/saveplaylist',(req,resu)=>{
  sess =req.session
  if(sess.auth === 1)
  {

    val = req.query.id
  const sql4 = `select * from musicinfo where id = ${val}`
  con.query(sql4,(err,resp)=>{
    if(err)
    {
      resu.redirect('./index2')
    }
    else{
      const id  = resp[0].id
      const trackname = resp[0].Trackname
      const plname = resp[0].playlistname
      const artname = resp[0].Artistname
      const duration = resp[0].duration
      const src  = resp[0].src
      const img = resp[0].img
      const reldate = resp[0].reldate
      const uid = sess.uname
      const artname2 = resp[0].Artist2
      const playurl = resp[0].playlisturl
  

      const  sql6 = `select uid from users where email='${uid}' `

      con.query(sql6,(error,response)=>{
        if(error)
        {
          
          resu.redirect('./index2')
        }
        const uval = response[0].uid
        const sql5=`INSERT INTO saveplaylist(playlistname,Artistname,Trackname,duration,src,img,reldate,playlisturl,Artist2,uid) VALUES('${plname}','${artname}','${trackname}',${duration},'${src}','${img}','${reldate}','${playurl}','${artname2}',${uval})`
     
      con.query(sql5 ,(err,result)=>{
        if(err)
      {
      
        resu.redirect('./index2')
      }
      else{
     
      resu.redirect('./new.php')
    }
      })
      })
    }
  })
  }
  else{
    resu.redirect('./leave.html')
  }
  
});


// New.Php page

app.get('/new',(req,res)=>{

  sess= req.session
  
  if(sess.auth === 1)
  {
    res.redirect('/new.php')
  }
  else
  {
    const sql7 = " TRUNCATE TABLE musicinfo"
    con.query(sql7,(er,re)=>{
      res.redirect('./validation/user-validation.html')
    })
  
  }

})

//Playlist
app.get('/playlist',(req,res)=>{
  sess =req.session
  if(sess.auth === 1)
  {
    const sql15 = `select uid from users where email='${sess.uname}'`
    con.query(sql15,(err,resu)=>{
      if(err)
      {
        res.redirect('./playlist.php?i=p')
      }
    
      const value = resu[0].uid
      
      res.redirect(`./playlist.php?i=${value}`)
    })
    }

  else
  {
    res.redirect('./validation/user-validation.html')
  }
});


//Forgot Password

app.post('/forgot',(req,res)=>{
  sess = req.session
  const email = req.body.email
  const password =req.body.password
  const rp_pass = req.body.rppassword

  const sql9 = `select * from users where email='${email}'`

  con.query(sql9,(error,respo)=>{
    if(error)
    {
      sess.error = "Email id is not registered"
      res.render("user-validation",{err:sess.error})
    }

   if(password===rp_pass)
  {
   global.vericode = randomInt(randomInt(1,40),randomInt(55,89)) + '' +  randomInt(randomInt(100,240),randomInt(555,989)) 
    var transporter = nodemailer.createTransport({
      service: 'gmail',
      auth: {
        user: 'epic1470@gmail.com',
        pass: 'abcdefgh@12345'
      }
    });
    var mailOptions = {
      from: 'epic1470@gmail.com',
      to: email,
      subject: 'Verification code',
      text: 'Your Verification code for account is '+  global.vericode +'.'
    };
    transporter.sendMail(mailOptions).then((d)=>{
      res.redirect('./validation/verify_pass.html')
     
        // Verify Password
   app.post('/verifypass',(reqr,resr)=>{
    if( global.vericode === reqr.body.verifycode)
    {
     
      const ps =bcrypt.hash(password,8).then((dataa)=>{
        const sql12 = `update users set password='${dataa}' where email = '${email}'`

        con.query(sql12 , (e,r)=>{
          if(e)
          {
            sess.error= "Error Try Again Later" 
            resr.render("user-validation",{err:sess.error})
          }
          sess.status = "Password Changed Successfully"
          resr.render("user-validation",{err:sess.status})
        })

      }).catch((ee)=>{
        sess.error= "Error Try Again Later"
        resr.render("user-validation",{err:sess.error})
      })


    }
else
{
sess.error= "Verification code Do not Match"
resr.render("user-validation",{err:sess.error})
}

})

    }).catch((er)=>{
      sess.error= "Error Try Again Later"
      res.render("user-validation",{err:sess.error})
    });

  }
  
  else
  {
    sess.error= "Password Do not Match"
    res.render("user-validation",{err:sess.error})
  }
  })



});


 

//logout

app.get('/logout',(req,res)=>{
  sess =req.session
  if(sess.auth === 1)
  {
    
    req.session.destroy((err)=>{
      res.redirect('/')
    })
    
  }
  else
  {
    res.redirect('./index.html')
  }

})

 //Rest
      app.get('*',(req,res)=>{
     res.redirect('../pagenotavail.html')
      })
app.listen(port, () => console.log(`Example app listening on port port!`))