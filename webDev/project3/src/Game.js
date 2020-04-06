import $ from 'jquery';
import {parse_json} from "./parse_json";

export const Game = function(sel) {
    // Handles pressing movement buttons

    this.form = $("form");
    const submit = this.form.find('#go');
    submit.click(function(event) {
        event.preventDefault();
        this.inputType = $($('input')[0]).attr("name"); // which input type such as whodidit or actChoice
        this.inputID = null;
        for(var i = 0; i< $('input').length;i++){
            this.inputID=$($('input')[i]).attr("id");
            //console.log($('input[id="'+this.inputID+'"]:checked').length > 0);
            if ($('input[id="'+this.inputID+'"]:checked').length > 0){ // Checks what radio is selected
                break;
            }
        }
        var param = {
            url: "game-post.php",
            method: "POST",
            success: function(data) {
                if(data !== null) {
                    console.log("success");
                    $(sel).html(data);
                }else{
                    $(sel + " .message").html("<p>'"+this.inputType +"' Failed!</p>");
                }
            },
            error: function (xhr, status, error) {
                $(sel + " .message").html("<p>Error: " + error + "</p>");
            }
        };
        if (this.inputType == "actChoice"){
            param.data = {actChoice:this.inputID};
        }
        else if(this.inputType == "whodiddit"){
            param.data = {whodiddit:this.inputID};
        }
        else if (this.inputType == "whatdiddit"){
            param.data = {whatdiddit:this.inputID};
        }
        else{
            console.log("error: 123 ", this.inputType);
        }
        $.ajax(param);
        return false;

    });
    $("button[name='cell']").click(function (event) {
        event.preventDefault();
        event.stopPropagation();
        // The value of the button has the location in a pair, for example (7,3)
        console.log($(this).val());
        $.ajax({
            url: "game-post.php",
            data: {cell:$(this).val()},
            method: "POST",
            success: function(data) {
                if(data !== null) {
                     $(sel).html(data);
                }else{
                    $(sel + " .message").html("<p>Movement Failed!</p>");
                }
            },
            error: function (xhr, status, error) {
                $(sel + " .message").html("<p>Error: " + error + "</p>");
            }
        });
        return false;
    });

    $("input[name='pass']").click(function (event) {
        event.preventDefault();

        $.ajax({
            url: "game-post.php",
            data: {pass:"pass"},
            method: "POST",
            success: function(data) {
                if(data !== null) {
                    $(sel).html(data);
                }else{
                    $(sel + " .message").html("<p>Pass Failed!</p>");
                }
            },
            error: function (xhr, status, error) {
                $(sel + " .message").html("<p>Error: " + error + "</p>");
            }
        });
        return false;
    });
};