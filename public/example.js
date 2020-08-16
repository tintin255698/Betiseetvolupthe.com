window.onload = () => {
    let stripe = Stripe('pk_test_51HEWz5LDGj5KeXGgk5GqlhnrvTh5Clr5X3t2gZheY6oRsfV9OFQmmoAaYeGa3T7p8Prn2TyOXaTCv4mU99dKLj1k001n8of7TD')
    let elements = stripe.elements()
    let redirect = "http://127.0.0.1:8000/"

    let cardHolderName = document.getElementById("cardholder-name")
    let cardButton = document.getElementById("card-button")
    let clientSecret = cardButton.dataset.secret;

    let card = elements.create("card")
    card.mount("#card-elements")

    card.addEventListener("change", (event)=> {
        let displayError = document.getElementById("card-errors")
        if(event.error){
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = "";
        }
    })

    cardButton.addEventListener("click", () => {
        stripe.handleCardPayment(
            clientSecret, card, {
                payment_method_data: {
                    billing_details: {name: cardHolderName.value}
                }
            }
        ).then((result) => {
            if (result.error){
                document.getElementById("errors").innerText = result.error.message
            }else{
                document.location.href = redirect
                form.submit();

            }
        })
    })
}
