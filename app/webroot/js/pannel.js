$(document).ready(function () {
    $(".historique-button").click(function () {
        var id = $(this).attr('data-value');
        $("#historique-fiche" + id).toggle();
    });


    $(".boutonList").click(function () {
        $("tr[class^='selectDestTrans']").hide();
        $("tr[class^='selectValidDest']").hide();
        $("tr[class^='selectConsultDest']").hide();


        var variable = $(this).attr('value');
        if ($('#listeValidation' + variable).is(':visible')) {
            $('.listeValidation').hide();
        }
        else {
            $("tr[class^='selectDestTrans']").hide();
            $('.listeValidation').hide();
            $('#listeValidation' + variable).show();
        }
    });
    
    
    $(".boutonListValidee").click(function () {
        var variable = $(this).attr('value');
        if ($('#listeValidee' + variable).is(':visible')) {
            $('.listeValidee').hide();
        }
        else {
            $('.listeValidee').hide();
            $('#listeValidee' + variable).show();
        }
    });
    
    
    $(".boutonListRefusee").click(function () {
        var variable = $(this).attr('value');
        if ($('#listeRefusee' + variable).is(':visible')) {
            $('.listeRefusee').hide();
        }
        else {
            $('.listeRefusee').hide();
            $('#listeRefusee' + variable).show();
        }
    });


    $(".boutonListAValider").click(function () {
        $("tr[class^='selectDest']").hide();
        var variable = $(this).attr('value');
        if ($('#listeAValider' + variable).is(':visible')) {
            $('.listeAValider').hide();
        }
        else {
            $('.listeAValider').hide();
            $('#listeAValider' + variable).show();
        }
    });


    $('.sendCancelTrans').click(function () {
        $("tr[class^='selectDestTrans']").hide();
        $("tr[class^='selectValidDest']").hide();
    });


    $('.sendCancel').click(function () {
        $("tr[class^='selectConsultDest']").hide();
        $("tr[class^='selectValidDest']").hide();
        $("tr[class^='selectDest']").hide();
    });
    
    
    $('.selectDestValidCancel').click(function () {
        $("tr[class^='selectDestValidValider']").hide();
    });
    
    
    $('.selectDestConsultCancel').click(function () {
        $("tr[class^='selectDestConsultValider']").hide();
    });
    
    
    $('.repondreCancel').click(function () {
        $("tr[class^='commentaireRepondre']").hide();
    });
    
    
    $('.refusCancel').click(function () {
        $("tr[class^='commentaireRefus']").hide();
    });
    
    
    $(".envoiConsult").click(function () {
        $('.listeValidation').hide();
        var variable = $(this).attr('value');
        $('.selectConsultDest' + variable).show();
        $('.selectValidDest' + variable).hide();
    });
    
    
    $(".envoiValid").click(function () {
        $('.listeValidation').hide();
        var variable = $(this).attr('value');
        $('.selectValidDest' + variable).show();
        $('.selectConsultDest' + variable).hide();
    });


    $(".envoiConsultValider").click(function () {
        var variable = $(this).attr('value');
        $('.selectorDestValidValider').hide();
        $('.selectorDestConsultValider').hide();
        $('.listeAValider').hide();
        $('.selectDestConsultValider' + variable).show();
    });


    $(".envoiValidValider").click(function () {
        var variable = $(this).attr('value');
        $('.selectorDestConsultValider').hide();
        $('.selectorDestValidValider').hide();
        $('.listeAValider').hide();
        $('.selectDestValidValider' + variable).show();
    });


    $(".boutonReorienter").click(function () {
        var variable = $(this).attr('value');
        if ($('.selectDestTrans' + variable).is(':visible')) {
            $('.selectDestTrans' + variable).hide();
        }
        else {
            $("tr[class^='selectDestTrans']").hide();
            $('.listeValidation').hide();
            $('.selectDestTrans' + variable).show();
        }
    });


    $(".boutonRefuser").click(function () {
        var variable = $(this).attr('value');
        if ($('.commentaireRefus' + variable).is(':visible')) {
            $('.commentaireRefus' + variable).hide();
        }
        else {
            $("tr[class^='commentaireRefus']").hide();
            $('.listeValidation').hide();
            $('.selectorDestConsultValider').hide();
            $('.selectorDestValidValider').hide();
            $('.commentaireRefus' + variable).show();
        }
    });


    $(".boutonRepondre").click(function () {
        var variable = $(this).attr('value');
        if ($('.commentaireRepondre' + variable).is(':visible')) {
            $('.commentaireRepondre' + variable).hide();
        }
        else {
            $("tr[class^='commentaireRepondre']").hide();
            $('.listeValidation').hide();
            $('.commentaireRepondre' + variable).show();
        }
    });
    
    $("#listEnCoursControle").hide();
    
    
    $("#liEnCoursControle").removeClass();
    
    
    $("#listEnCoursValidation").hide();
    
    
    $("#liEnCoursValidation").removeClass();
    
    
    $("#listEnCoursSignature").hide();
    
    
    $("#liEnCoursSignature").removeClass();
    
    
    $("#listSignees").hide();
    
    
    $("#liSignees").removeClass();
    
    
    $("#listARevoir").hide();
    
    
    $("#liARevoir").removeClass();
    
    
    $("#listEnCoursRedaction").show();
    
    
    $("#liEnCoursRedaction").addClass("active");
    
    
    $("#listDemandeAvis").hide();
    

    $('#aEnCoursRedaction').click(function () {
        $("#listEnCoursControle").hide();
        $("#liEnCoursControle").removeClass();
        $("#listEnCoursValidation").hide();
        $("#liEnCoursValidation").removeClass();
        $("#listEnCoursSignature").hide();
        $("#liEnCoursSignature").removeClass();
        $("#listSignees").hide();
        $("#liSignees").removeClass();
        $("#listARevoir").hide();
        $("#liARevoir").removeClass();
        $("#listEnCoursRedaction").show();
        $("#liEnCoursRedaction").addClass("active");
        $("#sousTitre").html("en cours de rédaction")
    });


    $('#aEnCoursValidation').click(function () {
        $("#listEnCoursRedaction").hide();
        $("#liEnCoursRedaction").removeClass();
        $("#listEnCoursControle").hide();
        $("#liEnCoursControle").removeClass();
        $("#listEnCoursSignature").hide();
        $("#liEnCoursSignature").removeClass();
        $("#listSignees").hide();
        $("#liSignees").removeClass();
        $("#listARevoir").hide();
        $("#liARevoir").removeClass();
        $("#listEnCoursValidation").show();
        $("#liEnCoursValidation").addClass("active");
        $("#sousTitre").html("en cours de validation")
    });


    $('#aSignees').click(function () {
        $("#listEnCoursRedaction").hide();
        $("#liEnCoursRedaction").removeClass();
        $("#listEnCoursControle").hide();
        $("#liEnCoursControle").removeClass();
        $("#listEnCoursValidation").hide();
        $("#liEnCoursValidation").removeClass();
        $("#listEnCoursSignature").hide();
        $("#liEnCoursSignature").removeClass();
        $("#listARevoir").hide();
        $("#liARevoir").removeClass();
        $("#listSignees").show();
        $("#liSignees").addClass("active");
        $("#sousTitre").html("validées")
    });


    $('#aARevoir').click(function () {
        $("#listEnCoursRedaction").hide();
        $("#liEnCoursRedaction").removeClass();
        $("#listEnCoursControle").hide();
        $("#liEnCoursControle").removeClass();
        $("#listEnCoursValidation").hide();
        $("#liEnCoursValidation").removeClass();
        $("#listEnCoursSignature").hide();
        $("#liEnCoursSignature").removeClass();
        $("#listSignees").hide();
        $("#liSignees").removeClass();
        $("#listARevoir").show();
        $("#liARevoir").addClass("active");
        $("#sousTitre").html("refusées")
    });


    $('#aDemandeValidation').click(function () {
        $("#listDemandeAvis").hide();
        $('#listDemandeValidation').show();
        $("#liDemandeAvis").removeClass();
        $("#liDemandeValidation").addClass("active");
    });
    
    
    $('#aDemandeAvis').click(function () {
        $("#listDemandeValidation").hide();
        $('#listDemandeAvis').show();
        $("#liDemandeValidation").removeClass();
        $("#liDemandeAvis").addClass("active");
    });


    $('#headerVosFiches').click(function () {

        if ($('#vosFiches').is(":visible")) {
            $('#vosFiches').toggle(300);
            $('#caretVosFiches').removeClass("glyphicon-chevron-up");
            $('#caretVosFiches').addClass("glyphicon-chevron-down");
        }
        else {
            $('#vosFiches').toggle(300);
            $('#caretVosFiches').removeClass("glyphicon-chevron-down");
            $('#caretVosFiches').addClass("glyphicon-chevron-up");
        }
    });
    

    $('#headerFichesAControler').click(function () {
        if ($('#fichesAControler').is(":visible")) {
            $('#fichesAControler').toggle(300);
            $('#caretFichesAControler').removeClass("glyphicon-chevron-up");
            $('#caretFichesAControler').addClass("glyphicon-chevron-down");
        }
        else {
            $('#fichesAControler').toggle(300);
            $('#caretFichesAControler').removeClass("glyphicon-chevron-down");
            $('#caretFichesAControler').addClass("glyphicon-chevron-up");
        }
    });


});
