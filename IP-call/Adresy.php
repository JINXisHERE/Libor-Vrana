<!DOCTYPE html>
<html>
<head>
<title>IP Calculator</title>
<meta charset="utf-8" />
    <style>
        body {
            font-family:Arial;
            font-size:15px;
        }
        .addr {
            width:30px;
        }
        .result {
            border-bottom: 1px solid #6a6ade;
            border-right: 1px solid #6a6ade;
        }
        .result .label {
            display:inline-block;
            width:200px;
        }
    </style>
</head>
<body>
    <h1>IP Calculator</h1>
    Zadejte IP adresu:
        <input type='text' class='addr' id='q1'> .
        <input type='text' class='addr' id='q2'> .
        <input type='text' class='addr' id='q3'> .
        <input type='text' class='addr' id='q4'>
    <br>
    Nejvyšší počet hostů:
        <input type='text' class='addr' id='hostNum'><br>
    Nejvyšší počet subnetů:
        <input type='text' class='addr' id='subnetNum'>
    <br>
    <br>
    <button onclick='calculate();'>Výsledek</button>
<hr>
    <div class='result'>
        <span class=label>IP Adresa :</span>
        <span class=value id=resIP></span>
    </div>
    <div class='result'>
        <span class=label>Subnet maska :</span>
        <span class=value id=resMask></span>
    </div>
    <div class='result'>
        <span class=label>Subnet Id  :</span>
        <span class=value id=resSubnetId></span>
    </div>
    <div class='result'>
        <span class=label>Net Adresa :</span>
        <span class=value id=resNet></span>
    </div>
    <div class='result'>
        <span class=label>Broadcast Adresa :</span>
        <span class=value id=resBC></span>
    </div>
    <div class='result'>
        <span class=label>Standardtni třída :</span>
        <span class=value id=resClass></span>
    </div>

    <div class='result'>
        <span class=label>Rozsah :</span>
        <span class=value id=resRange></span>
    </div>
    <div class='result'>
        <span class=label>IP Binarně :</span>
        <span class=value id=resBinIP></span>
    </div>
    <div class='result'>
        <span class=label>Maska Binarně :</span>
        <span class=value id=resBinMask></span>
    </div>
    <div class='result'>
        <span class=label>Net Adresa Binarně :</span>
        <span class=value id=resBinNet></span>
    </div>
    <div class='result'>
        <span class=label>BC Adresa Binarně :</span>
        <span class=value id=resBinBC></span>
    </div>
    <div class='result'>
        <span class=label>Max počet subnetů :</span>
        <span class=value id=resMaxNet></span>
    </div>
    <div class='result'>
        <span class=label>Max počet hostů :</span>
        <span class=value id=resMaxHost></span>
    </div>

</body>
    <script type='text/javascript'>
    function calculate(){

    var q1=document.getElementById('q1').value;
    var q2=document.getElementById('q2').value;
    var q3=document.getElementById('q3').value;
    var q4=document.getElementById('q4').value;

    var netNum=document.getElementById('subnetNum').value;
    var hostNum=document.getElementById('hostNum').value;


    var hostNumDbg=0;
    for(var i=32;i>=0;i--){
        if(hostNum >= Math.pow(2,i)){

        hostNumDbg=32-(i+1);
    break;
        }
    }
    var cidr=hostNumDbg;



    if(
        (q1>=0 && q1<=255) &&
        (q2>=0 && q2<=255) &&
        (q3>=0 && q3<=255) &&
        (q4>=0 && q4<=255) &&
        (cidr>=0 && cidr<=32)
    ){

    document.getElementById('resIP').innerHTML=q1 + "." + q2 + "." + q3 + "." + q4;

    var ipBin={};
        ipBin[1]=String("00000000"+parseInt(q1,10).toString(2)).slice(-8);
        ipBin[2]=String("00000000"+parseInt(q2,10).toString(2)).slice(-8);
        ipBin[3]=String("00000000"+parseInt(q3,10).toString(2)).slice(-8);
        ipBin[4]=String("00000000"+parseInt(q4,10).toString(2)).slice(-8);



    var standartClass="";
        if(q1<=126) {
        standartClass="A";
        }else if (q1==127) {
        standartClass="loopback IP"
        }else if (q1>=128 && q1<=191) {
        standartClass="B";
        }else if (q1>=192 && q1<=223) {
        standartClass="C";
        }else if (q1>=224 && q1<=239) {
        standartClass="D (Multicast Address)";
        }else if (q1>=240 && q1<=225) {
        standartClass="E (Experimental)";
        }else {
        standartClass="Out of range";
        }


    var mask=cidr;
    var importantBlock=Math.ceil(mask/8);
    var importantBlockBinary=ipBin[importantBlock];
    var maskBinaryBlockCount=mask%8;
        if(maskBinaryBlockCount==0)importantBlock++;
    var maskBinaryBlock="";
    var maskBlock="";
        for(var i=1;i<=8;i++){
        if(maskBinaryBlockCount>=i){
        maskBinaryBlock+="1";
        }else{
        maskBinaryBlock+="0";
        }
        }

maskBlock=parseInt(maskBinaryBlock,2);

    var netBlockBinary="";
    var bcBlockBinary="";
        for(var i=1;i<=8;i++){
        if(maskBinaryBlock.substr(i-1,1)=="1"){
        netBlockBinary+=importantBlockBinary.substr(i-1,1);
        bcBlockBinary+=importantBlockBinary.substr(i-1,1);
        }else{
        netBlockBinary+="0";
        bcBlockBinary+="1";
        }
        }


    var mask="";
    var maskBinary="";
    var net="";
    var bc="";
    var netBinary="";
    var bcBinary="";
    var rangeA="";
    var rangeB="";

        for(var i=1;i<=4;i++){
        if(importantBlock>i) {

        mask+="255";
        maskBinary+="11111111";
        netBinary+=ipBin[i];
        bcBinary+=ipBin[i];
        net+=parseInt(ipBin[i],2);
        bc+=parseInt(ipBin[i],2);
        rangeA+=parseInt(ipBin[i],2);
        rangeB+=parseInt(ipBin[i],2);
            }else if (importantBlock==i) {

    mask+=maskBlock;
    maskBinary+=maskBinaryBlock;
    netBinary+=netBlockBinary;
    bcBinary+=bcBlockBinary;
    net+=parseInt(netBlockBinary,2);
    bc+=parseInt(bcBlockBinary,2);
    rangeA+=(parseInt(netBlockBinary,2)+1);
    rangeB+=(parseInt(bcBlockBinary,2)-1);
    }else {

        mask+=0;
        maskBinary+="00000000";
        netBinary+="00000000";
        bcBinary+="11111111";
        net+="0";
        bc+="255";
        rangeA+=0;
        rangeB+=255;
    }

if(i<4){
    mask+=".";
    maskBinary+=".";
    netBinary+=".";
    bcBinary+=".";
    net+=".";
    bc+=".";
    rangeA+=".";
    rangeB+=".";
}
}


    var binaryHost="";
        for(var i=(31-cidr);i>=0;i--){
            binaryHost=binaryHost+"1";
        }
    var maxHost=parseInt(binaryHost,2);
    var binarySubnet="";
        for(var i=cidr;i>=0;i--){
        binarySubnet=binarySubnet+"1";
        }
    var maxSubnet=parseInt(binarySubnet,2);
    var binaryCurrentSubnetBlock="";
        for(var i=maskBinaryBlockCount;i>=0;i--){
        binaryCurrentSubnetBlock=binaryCurrentSubnetBlock+"1";
        }
    var maxCurrentSubnetBlock=parseInt(binaryCurrentSubnetBlock,2);


document.getElementById('resMask').innerHTML=mask;
document.getElementById('resNet').innerHTML=net;
document.getElementById('resBC').innerHTML=bc;
document.getElementById('resRange').innerHTML=rangeA + " - " + rangeB;
document.getElementById('resBinIP').innerHTML=ipBin[1]+"."+ipBin[2]+"."+ipBin[3]+"."+ipBin[4];
document.getElementById('resBinMask').innerHTML=maskBinary;
document.getElementById('resBinNet').innerHTML=netBinary;
document.getElementById('resBinBC').innerHTML=bcBinary;
document.getElementById('resClass').innerHTML=standartClass;
document.getElementById('resSubnetId').innerHTML=cidr;
document.getElementById('resMaxHost').innerHTML=maxHost+"počet možných hostitelů v aktuální podsíti";
document.getElementById('resMaxNet').innerHTML=maxSubnet+" z celkové možné podsítě, "+maxCurrentSubnetBlock+" možná podsíť v aktuálním bloku";
document.getElementById('resImportantBlock').innerHTML=importantBlock;
    }else{
        alert("špatně zadaná IP adresa");
    }

}
</script>
</html>     