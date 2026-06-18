<script>
    (function() {
        'use strict';

        window.sappcMergeRegistryTopEmpty = function(primary, overlay) {
            var out = Object.assign({}, primary || {});
            if (!overlay || typeof overlay !== 'object') {
                return out;
            }
            // Ref code is always from the registry row; only client, address, and contact overlay from application.
            ['client', 'contact_number', 'address'].forEach(function(key) {
                if (String(out[key] || '').trim() !== '') {
                    return;
                }
                if (overlay[key] == null || String(overlay[key]).trim() === '') {
                    return;
                }
                out[key] = overlay[key];
            });
            return out;
        };

        window.sappcRegistryTopFromChristeningApplicationSnap = function(snap) {
            if (!snap || typeof snap !== 'object') {
                return null;
            }
            var parts = [
                (snap.first_name || '').trim(),
                (snap.middle_name || '').trim(),
                (snap.family_name || '').trim()
            ].filter(Boolean);
            return {
                client: parts.join(' '),
                contact_number: (snap.guardian_contact || '').trim(),
                address: (snap.parent_address || '').trim()
            };
        };

        window.sappcRegistryTopFromConfirmationApplicationSnap = function(snap) {
            if (!snap || typeof snap !== 'object') {
                return null;
            }
            var parts = [
                (snap.first_name || '').trim(),
                (snap.middle_name || '').trim(),
                (snap.family_name || '').trim()
            ].filter(Boolean);
            return {
                client: parts.join(' '),
                address: (snap.address || '').trim(),
                contact_number: (snap.contact_number || snap.guardian_contact || '').trim()
            };
        };

        window.sappcRegistryTopFromBurialApplicationSnap = function(snap) {
            if (!snap || typeof snap !== 'object') {
                return null;
            }
            return {
                client: (snap.deceased_name || '').trim(),
                address: (snap.deceased_address || '').trim(),
                contact_number: (snap.claimant_contact || '').trim()
            };
        };

        window.sappcRegistryTopFromWeddingApplicationSnap = function(snap) {
            if (!snap || typeof snap !== 'object') {
                return null;
            }
            var groom = (snap.groom_full_name || '').trim();
            var bride = (snap.bride_full_name || '').trim();
            var client = groom;
            if (groom && bride) {
                client = groom + ' & ' + bride;
            } else if (bride) {
                client = bride;
            }
            return {
                client: client,
                contact_number: (snap.groom_contact || snap.bride_contact || '').trim(),
                address: (snap.groom_present_address || snap.bride_present_address || '').trim()
            };
        };

        window.sappcRegistryWorkflowUrlWithRecord = function(href, recordId) {
            var url = (href || '').trim();
            var id = recordId == null ? '' : String(recordId).trim();
            if (!url || !id) {
                return url;
            }
            var sep = url.indexOf('?') >= 0 ? '&' : '?';
            return url + sep + 'sappc_record=' + encodeURIComponent(id);
        };
    })();
</script>
