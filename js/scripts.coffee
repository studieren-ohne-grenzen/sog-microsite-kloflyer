addDots = (number) ->
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")

daysBetween = (date1, date2) ->
  oneDay = 24 * 60 * 60 * 1000

  date1Time = date1.getTime()
  date2Time = date2.getTime()

  difference = date1Time - date2Time

  return Math.round(difference/oneDay)

updateCountdown = ->
  days = daysBetween(new Date(2015, 6, 1), new Date())
  html = "Noch " + days + " Tage <small>bis 1. Juli</small>"
  $("span.countdown").html(html)

updateProgressbar = ->
  top = $("span.countdown").offset().top

  $("html, body").animate(
    {scrollTop: top}, "slow", "swing", updateProgressbarInner
  )

updateProgressbarInner = ->
  $.getJSON("data.php", (data) ->
    newFeeSum = data["fee_sum"]
    # oldFeeSum = $("span.feeSum").text().replace(/\/.*$/, "")
    # diffFeeSum = newFeeSum - oldFeeSum

    properties = {width: (newFeeSum/6500) * 100 + "%"}
    $("div.progressBar").animate(properties, "slow")
    $("span.feeSum").text(newFeeSum + "/6500 €")
  )

window.updateProgressbar = updateProgressbar

updateCountdown()
updateProgressbarInner()
