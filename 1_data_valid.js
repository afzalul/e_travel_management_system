    var stat=[true,true,true,true];
    function show_message(msg,color,id)
    {
        document.getElementById(id).style.color=color;
        document.getElementById(id).innerHTML=msg;
    }
    function enable_submit(formName)
    {
        let i=0;
        for(i=0;i<stat.length;i++)
        {
            if(!stat[i])
                break;
        }
        document.forms[formName]["submit"].disabled = i==stat.length? false : true;
    }
    function validate_name(formName,fieldName)
    {
        //console.log(fname);
        var name=document.forms[formName][fieldName].value.toLocaleLowerCase();
        //console.log(x.value);
        var flag=true;
        for(let i=0;i<name.length;i++)
        {
            if(! ( (name[i]>='a' && name[i]<='z') || name[i]==' ' || name[i]=='.' ) )
            {
                flag=false;
                break;
            }
        }
        stat[0]=flag;
        var color= flag==true? "green" : "red";
        var msg= flag==true? "" : "Only letter, dot('.') and space allowed";
        show_message(msg,color,fieldName);
        enable_submit(formName);
    }
    function validate_username(formName,fieldName)
    {
        var name=document.forms[formName][fieldName].value.toLocaleLowerCase();
        var flag=true;
        for(let i=0;i<name.length;i++)
        {
            if(! ( (name[i]>='a' && name[i]<='z') || (name[i]>='0' && name[i]<='9') || name[i]==' ' || name[i]=='_' || name[i]=='.') )
            {
                flag=false;
                break;
            }
        }
        stat[1]=flag;
        var color= flag==true? "green" : "red";
        var msg= flag==true? "" : "Only letter, dot('.'), underscore('_') and space allowed";
        show_message(msg,color,fieldName);
        enable_submit(formName);
    }
    function validate_password(formName,fieldName1,fieldName2)
    {
        var pass=document.forms[formName][fieldName1].value;
        var re_password=document.forms[formName][fieldName2].value;
        //console.log(pass)
        //console.log(re_pass)
        if(pass!="" && re_password!="")            
        {
            var color= pass==re_password? "green" : "red";
            var msg= pass==re_password? "" : "Password mismatch";
            stat[2]= pass==re_password? true : false;
            show_message(msg,color,fieldName1);
        }
        else
        {
            stat[2]=false;
            show_message("","green",fieldName1);
        }
        enable_submit(formName);
    }
    function validate_mobile_no(formName,fieldName)
    {
        var mobile=document.forms[formName][fieldName].value;
        
        var flag = mobile.length== 11 && mobile[0]=='0' && mobile[1]=='1' && (mobile[2]=='8' || mobile[2]=='6' || mobile[2]=='9' || mobile[2]=='5' || mobile[2]=='7' || mobile[2]=='3');
        
        stat[3]=flag;
        var color= flag==true? "green" : "red";
        var msg= flag==true? "" : "Invalid";
        show_message(msg,color,fieldName);
        enable_submit(formName);
    }
