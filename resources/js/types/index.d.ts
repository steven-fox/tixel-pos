export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
  auth: {
    user: User;
  };
};

export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string;
  created_at: string;
  updated_at: string;
}

export interface Pizza {
  id: number;
  customer_id: number;
  status: PizzaState;
  created_at: string;
  updated_at: string;
  customer: ?User;
}

export interface PizzaState {
    name: string;
    transitionable_states: string[];
}
