# Custom Social Media Platform Backend Engine

A robust, object-oriented PHP backend engine designed to power a fully featured social media application (similar to X/Twitter). The system features an architectural data layer managed via a centralized database controller, abstract domain models supporting role-based inheritance, and custom timeline delivery matrices integrated with privacy, block, and mute filtering.

---

## 🚀 Key Features

*   **Dynamic Feed Engine:** Dedicated controllers for delivering custom public timelines, personal user timelines, and tailored retweet matrices.
*   **Privacy & Safety Walls:** Real-time query-level filtering that automatically strips out content originating from blocked, blocking, or muted accounts.
*   **Role-Based User Architecture:** Extended domain logic dividing entities into standard `User`, `Content_Creator`, and administrative `Admin` roles.
*   **Engagements & Interactivity:** Out-of-the-box infrastructure for liking, commenting, bookmarking, and creating personalized save groups for both native posts and shared retweets.
*   **Advertisements & Monetization:** Specialized entities built for `Content_Creator` profiles to deploy custom advertisements alongside distinct ad-comment engagement tracks.
*   **System Moderation:** Built-in reporting system tracking users flagged for administrative review, including automated banning and reinstatement gates.

---

## 📂 Architecture & Project Structure

The project strictly separates system logic and entities using an organized MVC-style structure:

### ⚙️ Controllers
*   `DBController.php` — Core database abstraction layer implementing singleton configuration connectivity management.
*   `TweetPrintController.php` — Builds public, personalized, and targeted search timelines for native posts.
*   `RetweetPrintController.php` — Directs the shared post pipeline, retrieval mechanics, and user bookmark collections.
*   `PersonController.php` — Manages global user directories, follow graphs, social status tracking (mutes/blocks), and profile mutations.
*   `InteractiveController.php` — Computes engagement state updates (likes, comments, retweets) across multiple content types.
*   `NotificationController.php` — Drives standard contextual user alerts and chronological event logging.

### 💎 Models (Domain Objects)
*   `Person` — The structural parent class holding global user credentials, profile meta, and dates.
    *   `User` — Inherits from `Person`; represents the standard social participant.
    *   `Content_Creator` — Inherits from `Person`; authorizes specialized business functions like deploying advertisements.
    *   `Admin` — Inherits from `Person`; authorizes access to core platform moderation and user removal.
*   `Post` — Base platform content structure tracking media, visibility tags, and engagement counters.
*   `SharedPost` — Data layer map representing retweets, storing pointers to original authors and new contextual commentary.
*   `PostComment` / `AdComment` — Contextual interaction elements bound respectively to native posts or advertising modules.
*   `Advertisement` — Promotional entities linked directly to creator dashboards.
*   `Hashtag` — Metadata entity capturing system trends and utilization metrics.
*   `Notifications` — Holds real-time alert data, dispatch parameters, and read state logs.
*   `Report` — Contains complaints, target metrics, and detailed context logs for administrative evaluation.

---

## 🗄️ Database Entity Relationship Map

The architecture relies on standard relational keys to map actions securely across tables:

| Entity Relation Table | Primary Keys / Indicators | Key Operations Tracked |
| :--- | :--- | :--- |
| `person` | `id` (Auto-increment) | Profile, roles, images, credentials, and ban flags. |
| `post` | `postid` | Base text content, visibility states, and user ownership references (`pid`). |
| `sharedpost` | `shareid` | Pointers connecting new contexts (`newcontent`) to old posts (`postid`). |
| `followuser` | `pid`, `uid` | Social network mapping matching followers to corresponding targets. |
| `blockuser` / `muteuser` | `pid`, `uid` | Direct exclusion bounds checking utilized dynamically across timelines. |
| `savedpost` / `savedretweet` | `savepid`, `groupid` | Personalized bookmarking categories categorized under individual account scopes. |
| `report` | `rid` | System flags indexing complainant contexts against targeted user behavior. |

---

## 🛠️ Installation & Backend Setup

1. Clone this repository directly into your local development root environment:
```bash
   git clone [https://github.com/your-username/your-repository-name.git](https://github.com/your-username/your-repository-name.git)


   require_once 'Controllers/TweetPrintController.php';
   $timelineEngine = new TweetPrintController();