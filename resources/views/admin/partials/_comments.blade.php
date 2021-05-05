<div id="demande_notes" class="active">
    <div class="note_window_container">
        <div class="demande_old_messages_shadow"></div>
        <div id="demande-messages">
            <div class="message mine">
                <div class="profil">
                    <div class="avatar avatar-sm">
                        <span class="avatar-title rounded-circle bg-dark">MM</span>
                    </div>
                </div>

                <div class="content">
                    <div class="username">Mike Mike</div>
                    <div class="message-bubble">
                        <p style="white-space: pre-line;">this is long message for test message bubble width and possition in comment section</p>
                    </div>
                    <div class="moment">3-05-2021 @ 11:47</div>
                </div>
            </div>
            <div class="message">
                <div class="profil">
                    <div class="avatar avatar-sm">
                        <span class="avatar-title rounded-circle bg-dark">LG</span>
                    </div>
                </div>

                <div class="content">
                    <div class="username">Luc Gauvin</div>
                    <div class="message-bubble">
                        <p style="white-space: pre-line;">dada</p>
                    </div>
                    <div class="moment">3-05-2021 @ 11:22</div>
                </div>
            </div>
            <div class="message mine">
                <div class="profil">
                    <div class="avatar avatar-sm">
                        <span class="avatar-title rounded-circle bg-dark">MM</span>
                    </div>
                </div>

                <div class="content">
                    <div class="username">Mike Mike</div>
                    <div class="message-bubble">
                        <p style="white-space: pre-line;">test</p>
                    </div>
                    <div class="moment">3-05-2021 @ 11:47</div>
                </div>
            </div>
        </div>

        <div id="demande-comment-form" data-url="http://immigrempoi.local/admin/gestion/utilisateurs/4/saveComment">
            <textarea class="note form-control" id="note_message" name="message"></textarea>
            <button class="btn" type="button" data-scope="6091a70a9334e"><i class="fas fa-paper-plane"></i></button>
            <input type="hidden" name="model_id" id="note_model_id" value="{{ $demande->id }}" />
            <input type="hidden" name="model_type" id="note_model_type" value="App\Models\Demande" />
            <input type="hidden" name="category" id="note_category" value="" />
        </div>
    </div>
</div>
