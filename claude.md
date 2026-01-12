# Sophia Chat Plugin

## Architecture

### Overview
WordPress plugin that adds a support chat bubble for individuals affected by domestic violence. The plugin integrates with the external Sophia Chat service at `https://sophia.chat/secure-chat`.

### Structure
**Single-file plugin** - All functionality contained in `sophia-chat.php` (~320 lines)

```
sophia-plugin/
├── sophia-chat.php          # Main plugin file (all logic)
├── assets/
│   ├── css/
│   │   ├── sophia-chat.css  # Frontend bubble styling
│   │   └── admin.css        # Admin settings page styling
│   └── icons/Sophias/       # Avatar PNGs (served via CDN)
└── dist/                    # Distribution zips
```

### Key Constants
- `SOPHIA_CHAT_VERSION`: Current version
- `SOPHIA_CHAT_URL`: External chat service URL
- `SOPHIA_CHAT_ICON_CDN`: GitHub raw CDN for icons

### Components

**Frontend:**
- Chat bubble widget (fixed position, bottom-right)
- Opens chat in popup window with fallback to direct navigation
- Visibility logic (all pages, homepage only, specific pages, exclude pages)

**Admin:**
- Settings page under Settings > Sophia Chat
- Icon selector (20 avatars + custom URL option)
- Visibility controls

**Storage:**
WordPress options table with `sophia_chat_` prefix:
- `sophia_chat_icon` - Selected avatar ID
- `sophia_chat_custom_icon_url` - Custom icon URL
- `sophia_chat_visibility` - Display mode
- `sophia_chat_page_ids` - Pages to show on
- `sophia_chat_exclude_ids` - Pages to exclude

### Technical Decisions
- CDN-hosted icons (reduces plugin size)
- No API keys (URL-based popup integration)
- Accessibility-first (aria-labels, semantic HTML)
- Graceful degradation (popup fallback)
- Security: input sanitization, output escaping

---

## Workflow

### General Rules
- **Always create PRs** - Never push directly to main
- **No mentioning Claude** in any comments, code, or work
- Debug logging helps understand what's going on

---

### PR Review Prompt

Review these GitHub pull requests as a senior engineer.

Focus on:
- correctness and potential bugs
- security and data-handling risks
- performance and scalability
- code style and maintainability
- test coverage gaps
- backwards-compatibility risks

For each issue you find:
- quote the relevant code (or file + line numbers)
- explain why it's a problem
- suggest a concrete fix (code if helpful)
- label severity (blocker / high / medium / low)
- create and run tests

End with:
- an overall approval recommendation (approve / request changes)
- a short PR summary as a GitHub review comment directly added

PRs link:

---

### Updating PR (Fixed) Prompt

You are a senior engineer updating these PRs based on reviewer feedback. Your top priority is to minimise diff size and make review effortless.

**Non-negotiables**
- No refactors. Only change code required to satisfy specific PR comments.
- No formatting churn. Don't run prettier/formatter on unrelated files or touch whitespace.
- No renames/moves. Don't rename variables/files or restructure folders unless explicitly requested.
- Behaviour-preserving. Don't change runtime behaviour unless the reviewer asked for it.
- One change per comment. Keep each fix as local as possible.

**Workflow**
1. Read all PR comments. Questions / clarify
2. For each fix comment:
   - Quote the comment in your plan.
   - Apply the smallest possible change.
   - If multiple solutions exist, choose the simplest and explain why in one sentence.
3. Tests (required):
   - If relevant tests already exist, update only what's necessary.
   - If tests are missing for the touched behaviour, add minimal tests (1–3 cases) to cover the change and prevent regression.
   - Run tests locally after changes and capture the outcome.

**Commit strategy**
- Prefer a single commit titled: `fix: address PR feedback`
- Keep tests in the same PR. Avoid extra commits unless tests are unusually large.

**Deliverables (return exactly)**

A) Checklist mapping each reviewer comment → what you changed (1 line each)
B) Files touched (paths only)
C) Direct GitHub comment containing:
   - What changed (bullets)
   - Why (1 sentence total)
   - How to test (commands)
   - Test results (commands run + pass/fail summary)
D) If any comment is ambiguous: propose the simplest assumption and a single question.

PRs and feedback to review and implement - incl. Low and non-blocking feedback where appropriate:

---

### Complete Issues Prompt

You are a very senior software engineer AI completing issues to launch Sophia Hub.

Your work will be reviewed by another AI and must be:
- correct
- minimal
- readable by a human later
- safe to merge without discussion

Success = PR can be approved confidently in one pass.

**CORE RULES (NON-NEGOTIABLE)**
- Add only strictly necessary code
- No refactoring
- No style changes
- No new abstractions
- No new dependencies
- Follow existing code patterns exactly
- Keep diffs small and obvious
- Code must be human-maintainable later

**PHASE 1 — PLAN (NO CODE)**

1. Codebase Understanding

Briefly infer (no commands):
- Framework
- State management
- API pattern
- Auth pattern

→ Output max 4 bullets

2. Issue Breakdown

Group issues into small PRs.

Each PR must:
- solve one clear problem
- be logically independent
- be <400 lines total
- have one mental context

Output table:

| PR | Theme | Issues | Risk |
|----|-------|--------|------|

Risk = Low / Medium / High

3. PR Order

Order PRs by:
1. Risk (highest first)
2. Dependencies
3. Size

4. STOP

Output:
- Codebase summary
- PR table
- Any blocking questions

Do not implement until plan is complete.

**PHASE 2 — IMPLEMENT (ONE PR AT A TIME)**

For each PR:

1. Implement
   - One issue at a time
   - One commit per issue
   - Minimal diff
   - No unrelated changes

2. Internal Quality Check

Before finalising PR, ensure:

*Correctness*
- No runtime errors
- No broken flows

*Type Safety*
- No any
- No @ts-ignore
- No unsafe casts

*Cleanliness*
- No unused imports
- No dead code
- No console logs

*Security (if relevant)*
- Input validated
- Auth respected
- No XSS risks

3. PR Summary (MANDATORY)

Format exactly:

```
PR: [Theme]
Issues: #X, #Y
Risk: Low / Medium / High

What Changed
- #X — file — short description
- #Y — file — short description

How Verified
- Manual flow verified in browser
- No console errors
- TypeScript passes

Reviewer Focus
- Point to the 1–2 most important code sections
```

**HANDLING EDGE CASES**

*Ambiguity*
If behaviour is unclear:
- State the ambiguity
- Propose one default
- Wait for confirmation

*High-Risk Issues*
Explain:
- what changed
- why it's safe
- how failure is prevented

*Blocked Issues*
Stop immediately and explain the blocker.

**CODE STYLE RULES**

Prefer boring, explicit code:
```php
if (!$user) {
    set_error('User not found');
    return;
}
set_user($user);
```

Explicit error handling:
```php
try {
    save($data);
} catch (Exception $e) {
    set_error('Save failed');
}
```

Names over comments.

**ADDITIONAL RULES (NON-NEGOTIABLE)**

- PR scope rule: Group issues that make sense together. If your PR description needs more than 3 bullet points to explain what it does, split the PR.
- Testing requirement: For every PR, create and run tests sufficient to prove the change works as intended.
  - Prefer existing test patterns in the codebase.
  - Add only the minimum tests necessary (no over-testing).
  - If automated tests are not feasible, include explicit manual verification steps and explain why.
- Proof of correctness: Each PR must make it obvious why the code works, either through tests or clear verification steps. No assumptions, no "should work".

**NEVER DO**
- Refactor unrelated code
- Add helpers "for later"
- Change formatting
- Proceed when unsure

**FINAL GOAL**

Deliver:
- small, safe PRs
- predictable behaviour
- code a human can understand months later

Clarity > Cleverness. Stability > Speed.

PR Links: