(async () => {
    await faceapi.nets.ssdMobilenetv1.loadFromUri('/models');
    await faceapi.nets.tinyFaceDetector.loadFromUri("/models"),
    await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
    await faceapi.nets.faceExpressionNet.loadFromUri('/models');
    await faceapi.nets.ageGenderNet.loadFromUri("/models")
    
    const image = document.querySelector('img');
    const canvas = faceapi.createCanvasFromMedia(image);


    const detection = await faceapi
      .detectSingleFace(image, new faceapi.TinyFaceDetectorOptions())
      .withFaceLandmarks()
      .withFaceExpressions()
      .withAgeAndGender();

    const dimensions = {
        width: image.width,
        height: image.height
    };

    const resizedDimensions = faceapi.resizeResults(detection, dimensions);

    document.body.append(canvas);

    faceapi.draw.drawDetections(canvas, resizedDimensions);
    faceapi.draw.drawFaceLandmarks(canvas, resizedDimensions);
    faceapi.draw.drawFaceExpressions(canvas, resizedDimensions);

    if (resizedDimensions && Object.keys(resizedDimensions).length > 0) {
     
        const gender = resizedDimensions.gender;
        const expressions = resizedDimensions.expressions;

        const maxValue=Math.max(...Object.values(expressions));
      
        const emotion = Object.keys(expressions).filter(
          item => expressions[item] === maxValue
        );
       
        document.getElementById("gender").innerText = `Gender - ${gender}`;
        document.getElementById("emotion").innerText = `Emotion - ${emotion[0]}`;
      }

})();