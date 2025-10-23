<?php
// Get the POSTed data
$customer_type = filter_input(INPUT_POST, 'type');
$invoice_subtotal = filter_input(INPUT_POST, 'subtotal', FILTER_VALIDATE_FLOAT);

if ($customer_type === null) {
    $customer_type = '';
}

// Only set $invoice_subtotal to empty string if no valid input
if ($invoice_subtotal === null || $invoice_subtotal === false) {
    $invoice_subtotal = '';
}

$discount_percent = 0;
$discount = 0;
$total = 0;
$percent = 0;

if ($invoice_subtotal !== '') {

    // Convert to uppercase
    $customer_type = strtoupper($customer_type);

    // --- SWITCH STATEMENT VERSION ---
    switch ($customer_type) {
        case 'R':
            if ($invoice_subtotal < 100) {
                $discount_percent = 0.0;
            } else if ($invoice_subtotal >= 100 && $invoice_subtotal < 250) {
                $discount_percent = 0.10;
            } else if ($invoice_subtotal >= 250 && $invoice_subtotal < 500) {
                $discount_percent = 0.25;
            } else { // $500 or more
                $discount_percent = 0.30;
            }
            break;

        case 'C':
            $discount_percent = 0.20; // Always 20%
            break;

        case 'T':
            if ($invoice_subtotal < 500) {
                $discount_percent = 0.40;
            } else {
                $discount_percent = 0.50;
            }
            break;

        default:
            $discount_percent = 0.10; // Everyone else
            break;
    }

    // Calculate totals
    $discount = $invoice_subtotal * $discount_percent;
    $total = $invoice_subtotal - $discount;
    $percent = $discount_percent * 100;
}  // <-- Closing brace added here
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Total Calculator</title>
    <link rel="stylesheet" href="main.css" />
</head>
<body>
<main>
    <h1>Invoice Total Calculator</h1>
    <p>Enter the values below and click "Calculate".</p>
    <form action="." method="post">
        <div id="data" >
            <label>Customer Type:</label>
            <input type="text" name="type"
                   value="<?php echo htmlspecialchars($customer_type); ?>"><br>

            <label>Invoice Subtotal:</label>
            <input type="text" name="subtotal"
                   value="<?php echo htmlspecialchars($invoice_subtotal); ?>"><br>

            <label>Discount Percent:</label>
            <input type="text" disabled
                   value="<?php echo htmlspecialchars($percent); ?>"><span>%</span><br>

            <label>Discount Amount:</label>
            <input type="text" disabled
                   value="<?php echo htmlspecialchars($discount); ?>"><br>

            <label>Invoice Total:</label>
            <input type="text" disabled
                   value="<?php echo htmlspecialchars($total); ?>"><br>
        </div>
        <div id="buttons" >
            <label>&nbsp;</label>
            <input type="submit" value="Calculate" id="calculate_button"><br>
        </div>
    </form>

</main>
</body>
</html>