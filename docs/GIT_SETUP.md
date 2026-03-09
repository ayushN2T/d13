# Git Setup

Use this after TYPO3 is working locally.

## Repository Values

- Remote: `git@github.com:ayushN2T/d13.git`
- Branch: `main`

## Setup Steps

1. Initialize Git:

```bash
git init
```

2. Set the main branch:

```bash
git branch -M main
```

3. Add the GitHub remote:

```bash
git remote add origin git@github.com:ayushN2T/d13.git
```

4. Add project files:

```bash
git add .
```

5. Create the first commit:

```bash
git commit -m "chore: bootstrap TYPO3 v13 with introduction package"
```

6. Push to GitHub:

```bash
git push -u origin main
```
