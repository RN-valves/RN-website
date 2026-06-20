@extends('users.master')
@section('seo_tags')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<style>
.chat-container {
    max-width: 600px;
    margin: 85px auto;
    padding: 60px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.chat-history {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 20px;
    padding: 10px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.chat-message {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.user-message {
    background-color: #007bff;
    color: #fff;
    text-align: right;
}

.assistant-message {
    background-color: #e9ecef;
    color: #333;
    text-align: left;
}

.loading {
    font-style: italic;
    color: #666;
}
</style>
<div class="chat-container">
    <div class="chat-box">
        <h5>How can I help you?</h5>
        <hr>
        <div id="chat-history" class="chat-history">
            <!-- Dynamic chat history will be appended here -->
        </div>
        <form id="chat-form">
            @csrf
            <input type="hidden" id="url" value="{{ url('all/ask/ask-question/1') }}">
            <input type="text" id="question" class="form-control" name="question" placeholder="Ask your question..." required>
            <button type="submit" class="btn btn-primary btn-sm float-right mt-3">Send</button>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#chat-form').submit(function (event) {
            event.preventDefault();

            const question = $('#question').val();
            const urlid = $('#url').val();

            // Append user message to chat history
            const userMessage = $('<div>')
                .addClass('chat-message user-message')
                .text(question);
            $('#chat-history').append(userMessage);
            $('#question').val('');

            // Add a loading indicator for the assistant's response
            const loadingIndicator = $('<div>')
                .addClass('chat-message assistant-message loading')
                .text('Typing...');
            $('#chat-history').append(loadingIndicator);
            $('#chat-history').scrollTop($('#chat-history')[0].scrollHeight);

            // Make AJAX request
            $.ajax({
                url: urlid,
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({ question: question }),
                success: function (data) {
                    // Remove the loading indicator
                    loadingIndicator.remove();

                    // Append assistant's response to chat history
                    const assistantMessage = $('<div>')
                        .addClass('chat-message assistant-message')
                        .text(data.answer);
                    $('#chat-history').append(assistantMessage);
                    $('#chat-history').scrollTop($('#chat-history')[0].scrollHeight);
                },
                error: function () {
                    // Handle errors
                    loadingIndicator.text('Sorry, something went wrong. Please try again.');
                }
            });
        });
    });
</script>

@endsection