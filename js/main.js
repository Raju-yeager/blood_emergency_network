async function toggleAvailability(donorId, buttonElement) {
    try {
        const response = await fetch('donor_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: donorId })
        });
        const result = await response.json();
        
        if (result.success) {
            if (result.new_status === 0) {
                buttonElement.innerText = 'Mark Active';
                buttonElement.closest('tr').style.opacity = '0.5';
            } else {
                buttonElement.innerText = 'Mark Inactive';
                buttonElement.closest('tr').style.opacity = '1.0';
            }
        } else {
            alert('Error updating status: ' + result.error);
        }
    } catch (err) {
        console.error('Request failed', err);
    }
}