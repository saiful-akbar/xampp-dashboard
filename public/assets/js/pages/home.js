import App from "../app.js";

/**
 * @class Home
 * @extends {App}
 */
class Home extends App {
  /**
   * Handle dlelete project
   *
   * @memberof Home
   */
  handleDelete = () => {
    [...document.querySelectorAll(".btn-delete-project")].map((el) =>
      el.addEventListener("click", (e) => {
        e.preventDefault();

        const { id } = el.dataset;
        const message = "Are you sure you want to delete this data?";

        if (confirm(message)) {
          window.location.href = this.route("home/delete", [
            { key: "id", value: id },
          ]);
        }
      })
    );
  };
}

const home = new Home();
home.handleDelete();
