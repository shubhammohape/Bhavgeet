const express = require('express')
const app = express()
const port = 3000;
const sphp = require('sphp')
app.use(sphp.express(__dirname));
app.use(express.static(__dirname))
const spotify =require('spotify-web-api-node');
const spotifyApi = new spotify({
  clientId: 'd97803efc75d48ea81360766acd7c5bb',
  clientSecret: 'd9db9f7988c3495e845aed7f21237fa6',
  redirectUri: 'http://localhost:3000/callback'
});
const mysql = require('mysql');
const { request } = require('http');

var con = mysql.createConnection({
  host: "127.0.0.1",
  user: "root",
  password: "",
  database:"spotify-api"
});



app.get('/video',(req,res)=>{
  res.redirect('/det_video.html')
} )

app.get('/authorize',(req,res)=>{
   app.locals.global_value = req.query.m;
 
    var scopes = ' streaming user-read-private user-read-email';
    res.redirect('https://accounts.spotify.com/authorize'+
      '?response_type=code' +
      '&client_id=d97803efc75d48ea81360766acd7c5bb'+
      (scopes ? '&scope=' + encodeURIComponent(scopes) : '') +
      '&redirect_uri=' + encodeURIComponent('http://localhost:3000/callback'));

      app.get('/callback',(reqr,res)=>{
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
          res.send(`Callback Error: ${error}`);
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
              const trackname = data.body.tracks.items[i].track.name;
              const duration = data.body.tracks.items[i].track.duration_ms;
              const src = data.body.tracks.items[i].track.external_urls.spotify;
              const img = data.body.tracks.items[i].track.album.images[0].url;
              const reldate = data.body.tracks.items[i].track.album.release_date;
              
              const sql = `insert into musicinfo(playlistname,Artistname,Trackname,duration,src,img,reldate,playlisturl,Artist2) values('${plname}','${artistname}','"${trackname}"',${duration},'${src}','${img}','${reldate}','${plurl}','${artistname2}')`
            
              con.query(sql,(err,resp)=>{
                if (err) {
                  return console.log(err)
                 }
                
              })
            }
            res.redirect('/new.php')
          }).catch((error)=>{
            res.send(`Error : ${error}`);
          })
        }).catch((error)=>{
            res.send(`Error getting Tokens: ${error}`);
        });
      
     
      });
    
})
app.get('/',(req,res)=>{
  
});
app.get('/webcam',(req,res)=>{
  res.redirect('/webcam_ext.html')
});


app.listen(port, () => console.log(`Example app listening on port port!`))