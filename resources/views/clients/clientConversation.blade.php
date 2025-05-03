@extends('components.clientLayout')

@section('title', 'Conversation')

@section('Content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Conversation about {{ $property->title }}</h2>
        <a href="{{ route('messages') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Messages
        </a>
    </div>
    <div class="card shadow-sm hover-shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="bi bi-house me-2"></i>{{ $property->title }}</h4>
            <p class="text-muted mb-0">Agent: {{ $agent->name }}</p>
        </div>
        <div class="card-body" style="max-height: 500px; overflow-y: auto; display: flex; flex-direction: column-reverse;">
            @if($messages->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-chat-dots mb-2" style="font-size: 2rem;"></i>
                    <p class="mb-0">No messages yet. Start the conversation below.</p>
                </div>
            @else
                @foreach($messages as $message)
                    <div class="mb-3 {{ $message->sender_type === 'client' ? 'text-end' : 'text-start' }}">
                        <div class="d-inline-block p-3 rounded {{ $message->sender_type === 'client' ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 70%;">
                            <p class="mb-1">{{ $message->message }}</p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="card-footer">
            <form id="sendMessageForm">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}">
                <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                <div class="input-group">
                    <textarea class="form-control" name="message" rows="2" placeholder="Type your message..." required></textarea>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardBody = document.querySelector('.card-body');
    cardBody.scrollTop = 0;

    const form = document.getElementById('sendMessageForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = form.querySelector('[name=message]').value;
        const propertyId = form.querySelector('[name=property_id]').value;
        const agentId = form.querySelector('[name=agent_id]').value;
        const csrfToken = form.querySelector('[name=_token]').value;

        if (!message.trim()) {
            showToast('Please enter a message', 'warning');
            return;
        }

        try {
            const response = await fetch('{{ route('client.sendMessage') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    property_id: propertyId,
                    agent_id: agentId,
                    message: message
                })
            });

            if (response.ok) {
                const messageContainer = document.createElement('div');
                messageContainer.className = 'mb-3 text-end';
                messageContainer.innerHTML = `
                    <div class="d-inline-block p-3 rounded bg-primary text-white" style="max-width: 70%;">
                        <p class="mb-1">${message}</p>
                        <small class="text-muted">${new Date().toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</small>
                    </div>
                `;
                cardBody.prepend(messageContainer);
                cardBody.scrollTop = 0;
                form.reset();
                showToast('Message sent successfully', 'success');
            } else {
                const errorData = await response.json();
                showToast(errorData.message || 'Failed to send message', 'danger');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            showToast('An error occurred while sending the message', 'danger');
        }
    });

    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '1050';
            document.body.appendChild(toastContainer);
        }

        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast align-items-center text-white bg-${type}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        let icon = 'info-circle';
        if (type === 'success') icon = 'check-circle';
        if (type === 'danger') icon = 'exclamation-circle';
        if (type === 'warning') icon = 'exclamation-triangle';

        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${icon} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 5000 });
        bsToast.show();
        toast.addEventListener('hidden.bs.toast', function() { this.remove(); });
    }
});
</script>
@endsection